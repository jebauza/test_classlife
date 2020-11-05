<template>
    <div>
        <FullCalendar :options="calendarOptions" />
    </div>
</template>

<script>
import '@fortawesome/fontawesome-free/css/all.css';

import FullCalendar from '@fullcalendar/vue';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import timeGridPlugin from '@fullcalendar/timegrid';
import bootstrapPlugin from '@fullcalendar/bootstrap';

export default {
    components: {
        FullCalendar
    },
    mounted() {
        this.getAllSessions();
    },
    data() {
        return {
            calendarOptions: {
                initialDate: '2018-03-15',
                headerToolbar: {
                    start: 'prevYear, nextYear, dayGridMonth, timeGridWeek, timeGridDay',
                    center: 'title'
                },
                plugins: [ dayGridPlugin, interactionPlugin, timeGridPlugin, bootstrapPlugin],
                themeSystem: 'bootstrap',
                initialView: 'dayGridMonth',
                events: [
                    /* {
                        title  : 'event1',
                        start  : '2020-11-04'
                    },
                    {
                        title  : 'event2',
                        start  : '2020-11-05T10:00:00',
                        end    : '2020-11-05T12:30:00'
                    },
                    {
                        title  : 'event3',
                        start  : '2010-01-09T12:30:00',
                        allDay : false // will make the time show
                    } */
                ]
            }
        }
    },
    methods: {
        getAllSessions() {
            const url = '/cmsapi/calendar/get-sessions';

            axios.get(url)
            .then(res => {
                //console.log(res.data);
                let events = res.data.map(session => {
                    return {
                        title: `AULA: ${session.aula_id} / GRUPO: ${session.group_id}`,
                        start: session.calendar_date_ini.replace(' ', 'T'),
                        end: session.calendar_date_end.replace(' ', 'T'),
                    };
                });
                this.calendarOptions.events = events;
            });
        }
    },
}
</script>
