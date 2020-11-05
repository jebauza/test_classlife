<template>
    <div class="card border-primary mb-4">
        <div class="card-header border-primary">
            <h5 class="card-title text-primary font-weight-bold">Aula {{ filters.class }} - Grupo {{ filters.group }}</h5>
        </div>

        <div class="card-body">

            <div class="form-row">
                <div class="col-sm-6 form-group">
                    <label>Aula</label>
                    <select v-model="filters.class" class="form-control">
                        <option v-for="(room,index) in classrooms" :key="index">{{ room.aula_id }}</option>
                    </select>
                </div>
                <div v-show="filters.class" class="col-sm-6 form-group">
                    <label>Grupo</label>
                    <select v-model="filters.group" class="form-control">
                        <option v-for="(group,index) in groups" :key="index">{{ group.group_id }}</option>
                    </select>
                </div>
                <div class="col-12 table-responsive">
                    <table v-if="students.length" class="table table-striped">
                        <thead>
                            <tr class="bg-info">
                                <th scope="col">Alummno</th>
                                <th scope="col">Sessiones</th>
                                <th scope="col">Presente</th>
                                <th scope="col">Ausente</th>
                                <th scope="col">Retraso</th>
                                <th scope="col">Justificado</th>
                                <th scope="col">Horas</th>
                                <th scope="col">Horas Abs.</th>
                                <th scope="col">Faltas</th>
                                <th scope="col">Presente</th>
                                <th scope="col">Ausente</th>
                                <th scope="col">Retraso</th>
                                <th scope="col">Justificado</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr v-for="student in students" :key="student.name">
                                <td>{{student.name}}</td>
                                <td>{{student.sessions}}</td>
                                <td>{{student.Presente }}</td>
                                <td>{{student.Ausente}}</td>
                                <td>{{student.Retraso}}</td>
                                <td>{{student.Justificado}}</td>
                                <td>{{student.hours}}</td>
                                <td v-if="student.attendance_percentage==0">-</td>
                                <td v-else>{{student.attendance_percentage}} %</td>
                                <td>{{student.hours_Ausente}}</td>
                                <td>{{student.hours_Presente}}</td>
                                <td>{{student.hours_Ausente}}</td>
                                <td>{{student.hours_Retraso}}</td>
                                <td>{{student.hours_Retraso}}</td>

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.getClassrooms();
        },
        watch: {
            'filters.class': function(newValue, oldValue) {
                this.filters.group = '';
                this.groups = [];
                this.getGroups();
            },
            'filters.group': function(newValue, oldValue) {
                this.getStudents();
            }
        },
        data() {
            return {
                students:[],
                classrooms: [],
                groups: [],
                filters: {
                    class: '',
                    group:  ''
                }
            }
        },
        methods: {
            getStudents() {
                this.students = [];
                const url = `/cmsapi/students`;
                if(this.filters.class && this.filters.class)
                {
                    axios.get(url, {
                        params: this.filters
                    })
                    .then(res => {
                        this.students = res.data;
                        console.log( this.students);
                    });
                }
            },
            getClassrooms() {
                const url = `/cmsapi/students/get-classrooms`;
                axios.get(url)
                .then(res => {
                    this.classrooms = res.data;
                })
            },
            getGroups() {
                const url = `/cmsapi/students/get-groups`;
                axios.get(url, {
                    params: {
                        class: this.filters.class
                    }
                })
                .then(res => {
                    this.groups = res.data;
                })
            }
        },
    }
</script>
