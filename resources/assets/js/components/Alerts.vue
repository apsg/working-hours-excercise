<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div
                    v-for="(alert, index) in alerts" 
                    class="alert" :class="'alert-'+alert.type">
                    {{ alert.message }}

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click.prevent="onCloseAlert(index)">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data(){
            return{
                alerts: []
            }
        },

        mounted() {
            console.log('Component mounted.')
        },

        methods: {
            addAlert(type, message){
                this.alerts.push({
                    type: type,
                    message: message
                });
            },

            onCloseAlert(index){
                delete this.alerts[index];
            }
        }
    }
</script>
