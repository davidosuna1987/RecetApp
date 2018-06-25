<template>
    <article class="vd-card">
        <a :href="authorLink" class="vd-card__header">
            <div class="vd-card__avatar" :style="{backgroundImage: 'url('+recipe.user.avatar+')'}"></div>
            <div class="vd-card__author">{{ recipe.user.full_name }}</div>
        </a>
        <a :href="recipeLink" class="vd-card__hero"
            :style="{backgroundImage: 'url('+backgroundImage+')', pointerEvents: link ? 'all' : 'none'}">
        </a>
        <div class="vd-card__content">
            <div class="vd-card__actions">
                <a href="" @click.prevent="toggleLike(recipe.id)">
                    <span class="icon is-medium">
                      <i v-if="authuserLike" class="has-text-danger mdi mdi-24px mdi-heart"></i>
                      <i v-else class="mdi mdi-24px mdi-heart-outline"></i>
                    </span>
                </a>
                <a href="">
                    <span class="icon is-medium">
                      <i class="mdi mdi-24px mdi-comment-outline"></i>
                    </span>
                </a>
            </div>
            <span class="help m-t-0 m-b-5">{{ trans('recipes.likes', {count: recipe.likes.length}) }}</span>
            <a :href="authorLink" class="vd-card__title">{{ recipe.title }}</a>
            <div class="vd-card__text" v-line-clamp="2">{{ recipe.preparation }}</div>
            <div class="vd-card__comments"></div>
            <div class="vd-card__comment-box">
                <input class="vd-card__comment-input" type="text" :placeholder="trans('recipes.comments_placeholder')">
            </div>
        </div>
    </article>
</template>

<script>
    export default {
        props: {
            recipe: {
                type: Object,
                required: true,
                default: {},
            },
            link: {
                type: Boolean,
                required: false,
                default: true,
            },
        },

        computed: {
            authorLink() {
                return '';
            },
            recipeLink() {
                return this.link ? '/recipes/' + this.recipe.id : null;
            },
            backgroundImage() {
                return this.recipe.image ? this.recipe.image : 'https://source.unsplash.com/600x500/?meal';
            },
            authuserLike() {
                let vue = this;
                return _.find(vue.$root.authuser.likes, function(like) {
                    return like.recipe_id === vue.recipe.id;
                });
            }
        },

        methods: {
            toggleLike(recipe_id) {
                let formData = new FormData();
                formData.set('user_id', this.$root.authuser.id);
                formData.set('recipe_id', recipe_id);

                axios.post('/likes', formData).then(response => {
                    this.$root.getAuthuser();
                    if(response.data.action === 'like'){
                        this.recipe.likes.push(response.data.like);
                    }else{
                        let index = this.recipe.likes.map(like => like.id).indexOf(this.recipe.likes.id);
                        this.recipe.likes.splice(index, 1);
                    }
                }).catch(error => {
                    if(error.response && error.response.status && error.response.status === 419)
                        location.href = '/login';

                    console.info(error);
                });
            }
        }
    }
</script>
