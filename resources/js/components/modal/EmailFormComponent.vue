<template>
    <modal name="email-form"
           :min-width="200"
           :min-height="200"
           :pivot-y="0.5"
           :adaptive="true"
           :scrollable="true"
           :reset="true"
           width="60%"
           height="auto"
           @before-open="beforeOpen">
        <div class="box">
            <div class="partition" id="partition-register">
                <div class="partition-form">
                    <div class="partition-title">ВВЕДИТЕ СВОЙ E-MAIL
                            <div v-if="errors.has('email')" class="message-alert alert-danger">
                                <p  v-for="error in errors">{{ error.msg }} </p>
                            </div>
                          <message-component  v-bind="message"/>
                        </div>
                    <form  autocomplete="false">
                        <input v-validate="'required|email'" name="email" id="n-email" type="text" placeholder="Email" v-model="email">
                    </form>
                    <div class="button-set">
                        <button v-show="!errors.has('email')" v-if="showOrderButton"  id="goto-order-btn" @click="send">Заказать</button>
                        <button id="cancel-btn" @click="close">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    </modal>
</template>

<script>
    import axios from 'axios';
    const MODAL_WIDTH = 656;
    import MessageComponent from './MessageComponent';
    export default {
        name: "EmailFormComponent",
        components:{
            'message-component': MessageComponent
        },
        data () {
            return {
                modalWidth: MODAL_WIDTH,
                id: null,
                email: null,
                showOrderButton: false,
                message: {
                    show: false,
                    text: null,
                    image: false,
                    type: null
                }
            }
        },
        created () {
            this.modalWidth = window.innerWidth < MODAL_WIDTH
                ? MODAL_WIDTH / 2
                : MODAL_WIDTH
        },
        watch: {
            email: function (){
                this.showOrderButton = true;
            }
        },
        methods: {
            setMessage(show,text,image,type){
                this. message.show = show || false;
                this.message.text = text || null;
                this.message.image = image || false;
                this.message.type = type || null;
            },
            close() {
                this.$modal.hide('email-form');
            },
            beforeOpen(event){
                this.setMessage();
                this.email =  null;
                this.id = event.params.id;
            },
            send(){
                let loader = this.$loading.show({
                    // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    canCancel: true,
                    onCancel: this.onCancel,
                });
                this.setMessage();
                axios
                    .post(`api/order/${this.id}`,{place_id: this.id, email: this.email})
                    .then(response=>{
                        if(response.data.success){
                            var place = document.getElementById(this.id);
                            place.classList.remove('free');
                            place.classList.add('busy');
                            this.setMessage(true,response.data.message, false, 'alert-success');
                         }
                        this.showOrderButton = false;
                        loader.hide();
                    }).catch(error=>{
                        if(error.response.data.errors.email){
                            this.setMessage(true, error.response.data.errors.email[0], false, 'alert-danger') ;
                        }else if(error.response.data.errors.place_id){
                            this.setMessage(true, error.response.data.errors.place_id[0], true, 'alert-danger') ;
                            this.showOrderButton = false;
                        }else{
                            this.setMessage(true, error.message, false, 'alert-danger') ;
                        }
                        loader.hide();
                });

            },
        }
    }
</script>

<style lang="scss">
    $background_color: #404142;
    .box {
        background: white;
        overflow: hidden;
        width: 100%;
        height: 100%;
        border-radius: 2px;
        box-sizing: border-box;
        box-shadow: 0 0 40px black;
        color: #8b8c8d;
        font-size: 0;
        }

    .partition {
        width: 100%;
        height: 100%;
        .partition-title {
            box-sizing: border-box;
            padding: 30px;
            width: 100%;
            text-align: center;
            letter-spacing: 1px;
            font-size: 20px;
            font-weight: 300;

        }
        .partition-form {
            padding: 0 20px;
            box-sizing: border-box;
        }
    }

    .message-alert {
        position: relative;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;

        @media only screen and (max-width: 600px) {
            padding: 0;
        }

        p {
            font-size: 1rem;
            @media only screen and (max-width: 600px) {
                font-size: 0.3rem;
                text-overflow: ellipsis;
            }
        }
    }

    input[type=text] {
        display: block;
        box-sizing: border-box;
        margin-bottom: 4px;
        width: 100%;
        font-size: 12px;
        line-height: 2;
        border: 0;
        border-bottom: 1px solid #DDDEDF;
        padding: 4px 8px;
        font-family: inherit;
        transition: 0.5s all;
        outline: none;
    }

    button {
        background: white;
        border-radius: 4px;
        box-sizing: border-box;
        padding: 10px;
        letter-spacing: 1px;
        font-family: "Open Sans", sans-serif;
        font-weight: 400;
        min-width: 140px;
        margin-top: 8px;
        color: #8b8c8d;
        cursor: pointer;
        border: 1px solid #DDDEDF;
        text-transform: uppercase;
        transition: 0.1s all;
        font-size: 10px;
        outline: none;
        &:hover {
            border-color: mix(#DDDEDF, black, 90%);
            color: mix(#8b8c8d, black, 80%);
        }
    }
    .button-set {
        margin-right: -10px;
        margin-bottom: 8px;
    }
    #goto-order-btn,
    #cancel-btn,
    #close-btn{
        margin-right: 8px;
    }
    .pop-out-enter-active,
    .pop-out-leave-active {
        transition: all 0.5s;
    }
    .pop-out-enter,
    .pop-out-leave-active {
        opacity: 0;
        transform: translateY(24px);
    }
</style>
