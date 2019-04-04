<template>
    <div class="message" v-if="show">
            <div  :class="['message-alert', type]">
                <p>{{text}}</p>
            </div>
        <div class="image">
            <img v-if="image" src="/img/wasted.png">
        </div>
    </div>
</template>

<script>
    export default {
        name: "MessageComponent",
        props: ['show','text','type','image']
    }
</script>

<style scoped lang="scss">
    .message {
        display: flex;
        flex-flow: column wrap;

        .message-alert {
            position: relative;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
            @media only screen and (max-width: 600px) {
                padding: 0;
            }
        }
    }

    .image {
        display: flex;
        flex-flow: column wrap;
        justify-content: center;
        align-items: center;
        align-self: center;
        padding: 1% 5% 1% 5%;
    }

    p {
        font-size: 1rem;

        @media only screen and (max-width: 600px) {
            font-size: 0.3rem;
            text-overflow: ellipsis;
        }
    }

    img {
        width: 300px;

        @media only screen and (max-width: 600px) {
            width: 70px;
        }
    }
</style>
