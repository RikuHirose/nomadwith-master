<template>
    <transition name="modal">
        <div class="overlay" @click="$emit('close')">
            <div class="panel" @click.stop>
                <h3>Modals</h3>
                <form>
                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">text</label>
                      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="text" v-model="text"></textarea>
                    </div>

                    <button type="button" @click="sendContact()">メール送信する</button>
                </form>
                <button @click="$emit('close')">閉じる</button>
            </div>
        </div>
    </transition>
</template>


<script>
export default {
    name: 'contact',

    props: ['profileId'],

    data () {
        return {
            text: ''
        }
    },
    methods: {
        sendContact () {
          let url = `/api/v1/profiles/${this.profileId}/contact`

          let formData = new FormData();

          formData.append('mail_text',      this.text)
          formData.append('profile_id', this.profileId)

          axios.post(url, formData)
            .then(response => {
                console.log(response)
              this.text = null

              // window.location.href = '/posts'

            })
            .catch(error => {
              alert('fail')
            })
        },
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
 
.panel {
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
.modal-enter,
.modal-leave-active {
    opacity: 0;
}
 
.modal-enter .panel,
.modal-leave-active .panel{
    top: -200px;
}
</style>