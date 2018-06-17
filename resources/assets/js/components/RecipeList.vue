<template>
    <section class="recipe-list-section">
        <div class="columns is-multiline">
            <div v-for="(recipe, index) in recipes" class="column is-one-third-tablet">
                <recipe-card :recipe="recipe"></recipe-card>
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
