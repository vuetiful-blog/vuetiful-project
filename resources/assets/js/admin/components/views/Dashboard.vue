<template>
  <div>
    <div>Hello {{name}}</div>  
  </div>
</template>

<script type="text/javascript">
export default {
    created() {
        this.getUser();
    },
    methods: {
        getUser() {
            axios.get('/api/profile').then(response => {
                this.name = response.data.name;
            })
        }
    },
    data() {
        return {
            name: ''
        }
    }
}
</script>
