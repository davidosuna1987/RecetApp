<template>
    <section class="recipe-list-section">
        <div class="columns is-multiline bg-full-width">
            <div v-for="(recipe, index) in recipes" class="column is-one-third-tablet">
                <article class="vd-card">
                    <div class="vd-card__hero" :style="{backgroundImage: 'url('+backgroundImages[index]+')'}"></div>
                    <div class="vd-card__content">
                        <div class="vd-card__title">{{ recipe.title }}</div>
                        <div class="vd-card__author"></div>
                    </div>
                    <div class="vd-card__avatar"></div>
                </article>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                recipes: []
            }
        },

        computed: {
            backgroundImages() {
                return this.recipes.map(function(recipe) {
                    return recipe.image ? recipe.image : 'https://source.unsplash.com/600x500/?meal';
                });
            }
        },

        methods: {
            getRecipes() {
                axios.get('/recipes/fetch').then(response => {
                    this.recipes = response.data.recipes;
                });
            }
        },

        mounted() {
            this.getRecipes();
        }
    }
</script>
