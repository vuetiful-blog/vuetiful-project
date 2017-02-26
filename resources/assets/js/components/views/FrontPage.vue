<template>
    <div class="ui three doubling cards basic segment">
        <card :categories="[{link: '/', name: 'How To'}, {link: '/', name: 'In Depth'}]">
            <span slot="title">V-cloak: Dealing with load latency in Vue.js</span>
            <span slot="published">2 Days Ago</span>
            <p slot="description">If you’re using Vue as an HTML templating engine, i.e. you’re placing vue template items directly in your HTML, then you may have noticed that the raw template items display for a short time before the Vue instance loads, which can look pretty ugly.</p>
        </card>
        <card :categories="[{link: '/', name: 'Vuetiful Project'}]">
            <span slot="title">Vuetiful Project: Setting up an SPA with Vue.js and Laravel 5.4</span>
            <span slot="published">3 Days Ago</span>
            <p slot="description">
It seems a bit silly to be writing a blog about vue.js on WordPress (Sorry WordPress, I think you’re great!). I mean, surely I can design my own site!? So, I thought it would be a good idea to start by going through a project to design the website for this blog</p>
        </card>
        <card :categories="[{link: '/', name: 'How To'}]" :likes="2" :comments="1">
            <span slot="title">Slick File Uploads: Implementing a Bootstrap Progress Bar with vue-resource</span>
            <span slot="published">4 Days Ago</span>
            <p slot="description">
In my previous post I discussed how to make a prettified file input that returns the file object. In this post we are going to look at how to upload the file we receive from our file input component and implement a progress bar.</p>
        </card>
    </div>
</template>

<script type="text/javascript">
import Card from '../elements/Card.vue'
export default {
    components: {
        Card
    }
}
</script>
