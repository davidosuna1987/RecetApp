<template>
    <section class="recipe-form-section">
        <!-- <pre>{{ recipe }}</pre> -->
        <!-- <pre>{{ categories }}</pre> -->
        <!-- <pre>{{ tags }}</pre> -->

        <form class="recipe-form">
            <div class="columns is-multiline">
                <div class="column is-12">
                    <div class="vd-input has-label-primary">
                        <input v-model="recipe.title" class="vd-input-field" type="text" placeholder="Recipe title" />
                        <label class="vd-placeholder">Recipe title</label>
                    </div>
                </div>

                <div class="column is-12">
                    <p class="m-b-15">Select recipe categories</p>
                    <label v-for="category in categories" :for="'cat-'+category.id" class="vd-checkbox is-primary">
                        <input v-model="recipe.categories" :id="'cat-'+category.id" type="checkbox" :value="category.id">
                        <span class="vd-checkbox__info">
                            <span class="vd-checkbox__check"></span>
                            <span class="vd-checkbox__label">{{ category.name }}</span>
                        </span>
                    </label>
                </div>
            </div>

            <div class="columns">
                <div class="column is-4">
                    <div class="ingredients">
                        <p class="m-b-15">Ingredients</p>

                        <div v-for="(ingredient, index) in recipe.ingredients" class="ingredient-field">
                            <input v-model="recipe.ingredients[index]"
                                @keypress.enter.prevent="ingredientEnter($event)"
                                :class="{'is-last': index === recipe.ingredients.length - 1}"
                                class="ingredient-input"
                                placeholder="Type new ingredient"
                                type="text" />
                            <a @click="deleteIngredient(index)" class="delete is-small delete-ingredient"></a>
                        </div>

                        <p class="buttons is-right m-t-20">
                            <button @click.prevent="addIngredient()" class="button is-small is-primary">Add ingredient</button>
                        </p>
                    </div>
                </div>
                <div class="column is-8">
                    <p class="m-b-15">Preparation</p>

                    <div class="vd-textarea has-label-primary m-t-0">
                        <textarea @input="preparationInput($event)" class="vd-textarea-field" placeholder="Preparation" rows="5" v-html="recipe.preparation"></textarea>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-12">
                    <p class="m-t-20 m-b-15">Tags</p>

                    <div class="vd-tags has-label-primary">
                        <span v-for="(tag, index) in recipe.tags" class="vd-tag is-primary">
                            {{ tag }}
                            <a class="vd-tags__delete" @click.prevent="deleteTag(index)"></a>
                        </span>
                        <div @click.prevent="focusTagInput($event)" class="vd-tags__control">
                            <input @keypress.enter.prevent="addTag($event)"
                                class="vd-tags-field"
                                placeholder="Add tag"
                                type="text" />
                            <i class="vd-tag__icon"></i>
                        </div>
                    </div>
                </div>
            </div>

           <!--  <b-taginput
                v-model="recipe.tags"
                :data="filteredTags"
                autocomplete
                field="name"
                icon="label"
                placeholder="Add tag"
                @typing="getFilteredTags()">

                <template slot-scope="props">
                    <strong>{{props.option.id}}</strong>: {{props.name}}
                </template>

                <template slot="empty">
                    There are no tags
                </template>
            </b-taginput> -->
        </form>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                recipe: {
                    title: '',
                    preparation: '',
                    categories: [],
                    tags: [],
                    ingredients: [
                        '',
                    ],
                },
                categories: null,
                tags: null,
                filteredTags: null
            }
        },

        methods: {
            // Categories
                getCategories() {
                    axios.get('/categories').then(response => {
                        this.categories = response.data.categories;
                    }).catch(error => {
                        if(error.response && error.response.status && error.response.status === 419){
                            location.href = '/login';
                        }
                        console.info(error);
                    });
                },

            // Tags
                addTag(event) {
                    let tagFound = _.find(this.recipe.tags, function(tag) {
                        return tag.toLowerCase() === event.target.value.toLowerCase();
                    });

                    if(event.target.value && !tagFound)
                        this.recipe.tags.push(event.target.value);

                    event.target.value = '';
                },
                deleteTag(index) {
                    console.info(index);
                    this.recipe.tags.splice(index, 1);
                },
                focusTagInput(event) {
                    if(event.target.classList.contains('vd-tags__control'))
                        event.target.firstElementChild.focus();

                    if(event.target.classList.contains('vd-tags-field'))
                        event.target.focus();

                    if(event.target.classList.contains('vd-tag__icon'))
                        event.target.parentElement.firstElementChild.focus();
                },
                getFilteredTags(text) {
                    this.filteredTags = data.filter((option) => {
                        return option.name
                            .toString()
                            .toLowerCase()
                            .indexOf(text.toLowerCase()) >= 0
                    })
                },

            // Ingredients
                ingredientEnter(event) {
                    if(event.target.classList.contains('is-last'))
                        this.addIngredient();

                    return false;
                },
                addIngredient() {
                    if(!this.recipe.ingredients.length || this.recipe.ingredients[this.recipe.ingredients.length-1])
                        this.recipe.ingredients.push('');

                    setTimeout(function(){
                        $('.ingredient-input').last().focus();
                    }, 10);
                },
                deleteIngredient(index) {
                    this.recipe.ingredients.splice(index, 1);

                    if(this.recipe.ingredients.length === 0)
                        this.addIngredient();
                },

            // Recipe
                preparationInput(event) {
                    this.recipe.preparation = event.target.value;
                }
        },

        mounted() {
            this.getCategories();
        }
    }
</script>
