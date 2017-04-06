<template>
    <div>
        <article-form @input="setArticle"></article-form>
        <div class="ui divider"></div>
        <button class="ui primary button" type="submit" @click="saveArticle">Publish</button>
    </div>
</template>

<script type="text/javascript">
import ArticleForm from '@/admin/components/partials/ArticleForm.vue';
export default {
    components: {
        ArticleForm
    },
    methods: {
        setArticle(title, article) {
            this.title = title;
            this.article = article;
        },
        saveArticle() {
            axios.post('/api/articles', {
                title: this.title,
                article: this.article
            }).then(response => {
                console.log(response);
            });
        },
    },
    data() {
        return {
            title: '',
            article: ''
        }
    }
}
</script>
