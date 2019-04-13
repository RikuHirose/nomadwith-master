<template>
    <transition name="modal">
        <div class="overlay m-modal" @click="$emit('close')">
            <div class="m-modal__panel" @click.stop>
                <h3>Modals</h3>
                
                <button @click="$emit('close')">閉じる</button>
            </div>
        </div>
    </transition>
</template>


<script>
export default {
    name: 'modal',

    props: ['profileId'],

    data () {
        return {
            text: ''
        }
    },
    methods: {
    }
}
</script>

<style lang="scss">
.overlay {
    background: rgba(0, 0, 0, .8);
    position: fixed;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 900;
    transition: all .5s ease;
}
.m-modal {
    &__panel {
        width: 300px;
        height: 200px;
        background: #fff;
        padding: 20px;
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -150px;
        margin-top: -100px;
        transition: all .3s ease;
    }
}
.modal-enter,
.modal-leave-active {
    opacity: 0;
}
 
.modal-enter .panel,
.modal-leave-active .panel{
    top: -200px;
}
</style>