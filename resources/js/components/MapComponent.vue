<template>
    <div v-if="places" class="map"  v-on:click="doOrder">
        <email-form-component/>
        <div v-for="place in places" :key="place.id" :class="[placeClass, localeClass ? place.class : '']" :title="place.name"><div :id="place.id" :class="[place.is_free ? 'free' : 'busy']"></div></div>
    </div>
    <div v-else>
        <div v-show="dataErrors" class="alert alert-danger">
            {{dataErrors}}
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import EmailFormComponent from './modal/EmailFormComponent';
    export default {
        name: "MapComponent",
        components: {
            EmailFormComponent
        },
        data(){
            return {
                places: null,
                placeClass: 'place',
                localeClass: true,
                dataErrors: null
            }
        },
        created() {
            this.getPlaces();
        },
        methods: {
            getPlaces(){
                let loader = this.$loading.show({
                    // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    canCancel: true,
                    onCancel: this.onCancel,
                });
              axios
                  .get('api/places').then(response => {
                      this.places = response.data.data;
                      loader.hide();
              }).catch(error=>{
                  this.dataErrors =  error.message;
                  loader.hide();
              });
            },
            doOrder(event){
                var target = event.target;
                if(!this.inArray(target.classList,'coach') && this.inArray(target.classList,'free')){
                    var id = target.getAttribute('id');
                    if(id){
                        this.$modal.show('email-form',{id: id});
                    }
                };
            },
            inArray(list, needle){
                for(var i=0; i<=list.length; i++){
                    if(list[i] === needle){
                        return true;
                    }
                }
                return false;
            }
        }
    }
</script>

