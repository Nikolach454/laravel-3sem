<template>
    <div v-if="article != null" class="alert alert-primary alert-dismissible fade show" role="alert" style="position: fixed; top: 70px; right: 20px; z-index: 9999; min-width: 300px;">
        Добавлена новая статья <strong> <a :href="`/article/${article.id}`"> {{ article.name }}</a></strong>
        <button type="button" class="btn-close" @click="article = null"></button>
    </div>
</template>

<script>
    export default {
    data() { return { article: null } },
        created() {
            console.log('Vue component created');
            console.log('window.Echo:', window.Echo);

            window.Echo.channel('test')
                .listen('NewArticleEvent', (article) => {
                    console.log('Event received:', article);
                    this.article=article.article;
                });

            console.log('Subscribed to channel test');
        }
    }
</script>
