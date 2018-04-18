<template>
    <div class="card card-default">
        <div class="card-body row">
            <div class="col-md-3">
                <p>Select an employee:</p>
                <select v-model="selectedEmployee" class="form-control" required="required">
                    <option v-for="employee in employees" :value="employee.id">{{ employee.name }}</option>
                </select>
            </div>
            <div class="col-md-3">
                <p>Select date:</p>
                <input type="date" :min="today" v-model="selectedDate" class="form-control" required="required">
            </div>
            <div class="col-md-4 d-flex">
                <div>
                    <p>Starting hour:</p>
                    <vue-timepicker 
                        :minute-interval="10" 
                        v-model="startingHour">    
                    </vue-timepicker>
                </div>
                <div>
                    <p>Ending hour:</p>
                    <vue-timepicker 
                        :minute-interval="10" 
                        v-model="endingHour">    
                    </vue-timepicker>
                </div>
            </div>
            <div class="col-md-2">
                <p>Save:</p>
                <button 
                    class="btn btn-primary" 
                    :disabled="is_valid == false" 
                    @click="onSubmit()">
                    Save
                </button>
            </div>
        </div>

        <span v-if="isValidTime(startingHour) && isValidTime(endingHour) && !is_valid_times" class="alert alert-danger">Selected hours are invalid. Ending hour must be later than starting hour.</span>
        <span v-for="(error, index) in errors" class="alert alert-danger">{{ index }}: {{ error[0] }}</span>
    </div>
</template>

<script>
    import VueTimepicker from 'vue2-timepicker';

    export default {

        props: ['employees'],

        components: { VueTimepicker },

        data(){
            return {
                today: moment().add(1,'days').format('YYYY-MM-DD'),
                selectedDate: null,
                selectedEmployee: null,
                startingHour: {
                    HH: "",
                    mm: "",
                    ss: ""
                },
                endingHour: {
                    HH: "",
                    mm: "",
                    ss: ""
                },
                errors: {}
            }
        },

        mounted() {
            console.log('Component mounted.')
        }, 

        methods: {
            formatTime(timeObject){
                return timeObject.HH + ":" + timeObject.mm;
            },

            isValidTime(timeObject){
                return timeObject.HH && timeObject.mm;
            },

            compareTimes(time1, time2){
                if(time1.HH < time2.HH){
                    return -1;
                }else if(time1.HH == time2.HH){

                    if(time1.mm < time2.mm){
                        return -1;
                    }else if (time1.mm == time2.mm){
                        return 0;
                    }else{
                        return 1;
                    }
                }else{
                    return 1;
                }
            },

            onSubmit(){

                this.errors = {};

                let data = {
                    employee_id: this.selectedEmployee,
                    date: this.selectedDate,
                    starting_hour: this.formatTime(this.startingHour),
                    ending_hour: this.formatTime(this.endingHour)
                }

                axios.post('/time-intervals', data)
                    .then(r => {
                        this.$emit('saved', r.data);
                        this.clear();
                    })
                    .catch(err => {
                        if(err.response.status == 422){
                            console.log(err.response.data);
                            this.errors = err.response.data.errors;
                        }else{
                            alert(err.response.data);
                        }
                    });
            },

            clear(){
                this.selectedEmployee = null;
                this.selectedDate = null;
                this.startingHour = {
                    HH: "",
                    mm: "",
                    ss: ""
                };
                this.endingHour = {
                    HH: "",
                    mm: "",
                    ss: ""
                };
            }
        },

        computed: {
            is_valid(){
                return this.selectedEmployee != null
                    && this.selectedDate != null
                    && this.is_valid_times;
            },

            is_valid_times(){
                return this.isValidTime(this.startingHour)
                    && this.isValidTime(this.endingHour)
                    && this.compareTimes(
                        this.startingHour, 
                        this.endingHour) < 0;
            }
        }
    }
</script>
