<template>
    <a :href="recipeLink" class="vd-card" :style="{pointerEvents: link ? 'all' : 'none'}">
        <div class="vd-card__hero" :style="{backgroundImage: 'url('+backgroundImage+')'}"></div>
        <div class="vd-card__content">
            <div class="vd-card__title">{{ recipe.title }}</div>
            <div class="vd-card__author">{{ recipe.user.full_name }}</div>
        </div>
        <div class="vd-card__avatar" :style="{backgroundImage: 'url('+recipe.user.avatar+')'}"></div>
    </a>
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
            recipeLink() {
                return this.link ? '/recipes/' + this.recipe.id : null;
            },
            backgroundImage() {
                return this.recipe.image ? this.recipe.image : 'https://source.unsplash.com/600x500/?meal';
            },
        },
    }
</script>
