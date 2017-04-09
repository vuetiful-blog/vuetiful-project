<template>
    <div>
        <loader :loading="saving" loading-text="Saving Article"></loader>
        <article-form @input="setArticle"></article-form>
        <div class="ui divider"></div>
        <button class="ui primary button" type="submit" @click="saveArticle">Publish</button>
    </div>
</template>

<script type="text/javascript">
import ArticleForm from '@/admin/components/partials/ArticleForm.vue';
import Loader from '@/components/core/Loader.vue';
import SweetAlert from '@/mixins/SweetAlert.js';
import ValidationHandler from '@/mixins/ValidationHandler.js';

export default {
    components: {
        ArticleForm,
        Loader
    },
    mixins: [SweetAlert, ValidationHandler],
    methods: {
        setArticle(title, article) {
            this.title = title;
            this.article = article;
        },
        saveArticle() {
            this.saving = true;
            axios.post('/api/articles', {
                title: this.title,
                article: this.article
            }).then(response => {
                // Alert that the article was saved succesfully
                this.alertSuccess().then(() => {
                   // Push router to edit page
                });
            }).catch(error => {
                let response = error.response;
                if (response.status === 422) {
                    this.alertError({
                        html: this.getHtmlValidationErrors(response)
                    });
                }
            }).then(() => {
                this.saving = false;
            });
        },
    },
    data() {
        return {
            title: '',
            article: '',
            saving: false
        }
    }
}
</script>
