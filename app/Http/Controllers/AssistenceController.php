<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssistenceController extends Controller
{
    public function get_sessions()
    {
        $sessions = DB::table('cl_aulas_calendar')
                    ->oldest('calendar_date_ini')
                    ->get()
                    ->groupBy(['aula_id', 'group_id']);

        return view('sessions', ['sessions' => $sessions]);
    }

    public function get_calendar()
    {
        return view('calendar');
    }

    public function cmsapi_get_sessions()
    {
        $sessions = DB::table('cl_aulas_calendar')
                    ->oldest('calendar_date_ini')
                    ->get();

        return response()->json($sessions, 200);
    }

    public function get_students()
    {
        return view('students');
    }

    public function cmsapi_get_classrooms()
    {
        $classrooms = DB::table('cl_aulas_students')
                    ->select('aula_id')
                    ->groupBy('aula_id')
                    ->get();

        return response()->json($classrooms, 200);
    }

    public function cmsapi_get_groups(Request $request)
    {
        $request->validate([
            'class' => 'required|integer',
        ]);

        $groups = DB::table('cl_aulas_students')
                    ->where('aula_id', $request->class)
                    ->select('group_id')
                    ->groupBy('group_id')
                    ->get();

        return response()->json($groups, 200);
    }

    public function cmsapi_get_students(Request $request)
    {
        $request->validate([
            'class' => 'required|integer',
            'group' => 'required|integer',
        ]);

        /* sesiones del aula y grupo pasados */
        $sessions = DB::table('cl_aulas_calendar')
                    ->select('calendar_date_ini as date_ini', 'calendar_date_end as date_end')
                    ->where('aula_id', $request->class)
                    ->where('group_id', $request->group)
                    ->get();

        $countSessions = $sessions->count();

        /* Sumatoria del tiempo de duracion de cada sesion */
        $totalHour = $sessions->sum(function ($session) {
            $diff = date_diff(date_create($session->date_ini), date_create($session->date_end));
            return ($diff->h + $diff->i) / 60;
        });

        $students = DB::table('cl_aulas_attendance')
                        ->join('cl_students', 'cl_students.student_id', '=', 'cl_aulas_attendance.student_id')
                        ->whereIn('cl_aulas_attendance.attendance_date', $sessions->pluck('date_ini')->toArray())
                        ->where('aula_id', $request->class)
                        ->where('group_id', $request->group)
                        ->get()
                        ->groupBy(function ($item, $key) {
                            return $item->student_name." ".$item->student_lastname;
                        });

        $status = DB::table('cl_attendance_status')->get();

        /* lista de asistencia por estudiante*/
        $data = [];
        foreach ($students as $key => $attendances) {
            $student = [];
            $student['name'] = $key;
            $student['sessions'] = $countSessions;
            $student['hours'] = round($totalHour,2);
            foreach ($status as $index => $item) {
                $filtersAssistence = $attendances->where('attendance_status', $item->id);
                $student[$item->status] = $filtersAssistence->count();
                $student['hours_'.$item->status] =round( $filtersAssistence->sum(function ($a) use($sessions){
                    $currentSession = $sessions->where('date_ini', $a->attendance_date)->first();
                    $diff = date_diff(date_create($a->attendance_date), date_create($currentSession->date_end));
                    return ($diff->h + $diff->i) / 60;
                }),2);
            }
            $student['attendance_percentage'] = intval(round(100 - ($student['hours_Ausente'] * 100 / $student['hours'])));
            $data[] = $student;
        }

        return response()->json($data, 200);
    }
}
