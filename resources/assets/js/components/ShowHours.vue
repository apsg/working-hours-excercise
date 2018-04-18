<template>
    <div>

        <div class="row p-2">
            <div class="col-md-4">
                <h3>Number of days to show:</h3>
            </div>
            <div class="form-inline col-md-4">
                <a href="#" class="btn btn-light" 
                    @click.prevent="changeDays(-1)">-</a>
                <input type="number" min="1" name="days_selected" v-model="days_selected" class="form-control">
                <a href="#" class="btn btn-light" 
                    @click.prevent="changeDays(1)">+</a>
            </div>
            <div class="col-md-4">
                <span v-if="is_invalid" class="alert alert-danger">Invalid number of days</span>
            </div>
        </div>

        <div class="card-header" v-if="hasData()">
            Working hours in next {{ days_selected }} {{ daysSuffix }} (excluding today)
        </div>

        <div class="card-header" v-if="!hasData()">
            No working hours to show in next {{ days_selected }} {{ daysSuffix }}
        </div>

        <div class="d-flex days flex-wrap">
            <div class="day p-2 m-2 border text-center"
                v-for="(day, date) in data">
                <h5 class="border-bottom ">{{ date }}</h5>
                <div v-for="hours in day">
                    {{ hours.starting_hour }} - {{ hours.ending_hour }}
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {

        props: ['days'],

        data(){
            return {
                days_selected: 7, 
                is_invalid: false,
                data: []
            }
        },

        mounted() {
            if(this.days && this.days > 1){
                this.days_selected = this.days;
            }

            this.getData();
        },

        watch: {
            days_selected: function(val){
                
                if(!val || val < 1){
                   this.is_invalid = true;
                }else{
                    this.is_invalid = false;
                }

                this.data = {};
                this.getData();
            }
        },

        computed: {
            daysSuffix(){
                return this.days_selected == 1 ? 'day' : 'days';
            }
        },

        methods:{

            changeDays(days){

                if(!this.days_selected){
                    this.days_selected = 1;
                }

                this.days_selected = 
                    parseInt(this.days_selected) + parseInt(days);

                if(this.days_selected < 1){
                    this.days_selected = 1;
                }
            },

            getData(){

                if(this.days_selected && this.days_selected > 0){

                axios.get('/check-hours/'+this.days_selected)
                    .then(res => {
                        this.data = res.data;
                    })
                    .catch(err => console.log(err));
                }
            },

            hasData(){
                return Object.keys(this.data).length > 0;
            }

        }

    }
</script>

<style>

    
    .day{
        min-width: 150px;
    }

</style>