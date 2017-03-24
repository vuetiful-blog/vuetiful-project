<template>
    <div class="ui center aligned grid">
        <message :show="error.show">
          <span slot="header">{{error.header}}</span>
          <p slot="message">{{error.message}}</p>
        </message>

        <div class="ui ten wide left aligned column">
            <h1 class="ui header">
              <i class="sign in icon"></i>
              <div class="content">
                Login
              </div>
            </h1>

            <div class="ui segment">
                <div :class="['ui', {active: loading}, 'inverted', 'dimmer']">
                    <div class="ui loader"></div>
                </div>

                <form class="ui form">
                    <div class="field">
                        <label>Email</label>
                        <input type="text" placeholder="Email" v-model="email">
                    </div>
                    <div class="field">
                        <label>Password</label>
                        <input type="password" name="last-name" placeholder="Password" v-model="password">
                    </div>
                    <button class="ui primary button" @click.prevent="login">Login</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
import Message from "@/components/core/Message.vue";
export default {
    components: {
        Message
    },
    methods: {
        login() {
            this.error.show = false;
            this.loading = true;
            axios.post('/login', {
                    email: this.email,
                    password: this.password
                })
                .then(response => {
                    this.$router.push('/');
                }).catch(error => {
                    this.error.show = true;
                    if (error.response.status === 422) {  
                        this.error.header = "Authentication Failed!",
                        this.error.message = "Invalid email or password."
                    }else{
                        this.error.header = error.response.data.header
                        this.error.message = error.response.data.message
                    }
                }).then(() => {
                    this.loading = false;
                });
        }
    },
    data() {
        return {
            email: "",
            password: "",
            loading: false,
            error: {
              show: false,
              header: '',
              message: ''
            }
        }
    }
}
</script>
