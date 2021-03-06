<template>
    <section class="recipe-form-section">
        <form @submit.prevent="validateForm()" class="recipe-form" enctype="multipart/form-data">
            <div class="columns is-multiline">
                <div class="column is-12">
                    <p class="m-b-15">{{ trans('recipes.select_image_title') }}</p>
                    <div class="vd-file">
                        <div v-if="!recipe.image" class="vd-file__field">
                            <input id="image" class="vd-file__input" type="file" name="image" accept="image/*" @change="previewImage($event)">
                            <label for="image" class="vd-file__label">{{ trans('recipes.select_image') }}</label>
                        </div>
                        <div v-else class="vd-file__preview" :style="{backgroundImage: 'url('+recipe.image+')'}">
                            <div class="vd-file__clear" @click.prevent="recipe.image = null">{{ trans('recipes.clear_image') }}</div>
                        </div>
                    </div>
                </div>

                <div class="column is-12">
                    <div class="vd-input has-label-primary">
                        <input v-model="recipe.title"
                            @blur="titleBlur($event)"
                            v-validate.disabled="{ required: true, regex: /^([A-zÀ-ÿ0-9 ,.-/]+)$/ }"
                            class="vd-input-field"
                            type="text"
                            name="title"
                            :placeholder="trans('recipes.title')" />

                        <label class="vd-placeholder">{{ trans('recipes.title') }}</label>
                    </div>
                    <p v-if="errors.has('title')" class="help is-danger">{{ errors.first('title') }}</p>
                </div>

                <div class="column is-12 m-t-25">
                    <p class="m-b-15">{{ trans('recipes.select_categories') }}</p>
                    <label v-for="category in categories" :for="'cat-'+category.id" class="vd-checkbox is-primary">
                        <input v-model="recipe.categories"
                            @input="setCategoriesError()"
                            name="categories[]"
                            :id="'cat-'+category.id"
                            type="checkbox"
                            :value="category.id" />

                        <span class="vd-checkbox__info">
                            <span class="vd-checkbox__check"></span>
                            <span class="vd-checkbox__label">{{ category.name }}</span>
                        </span>
                    </label>
                    <p v-if="categoriesError" class="help is-danger">{{ categoriesError }}</p>
                </div>
            </div>

            <div class="columns m-t-30">
                <div class="column is-5">
                    <div class="ingredients">
                        <p class="m-b-15">{{ trans('recipes.ingredients') }}</p>

                        <div v-for="(ingredient, index) in recipe.ingredients" class="ingredient-field">
                            <input v-model="recipe.ingredients[index]"
                                @blur="ingredientBlur($event, index)"
                                @keypress.enter.prevent="ingredientEnter($event)"
                                v-validate.disabled="'required'"
                                :name="'ingredient-'+index"
                                :class="{'is-last': index === recipe.ingredients.length - 1}"
                                class="ingredient-input"
                                :placeholder="trans('recipes.ingredients_placeholder')"
                                type="text" />

                            <a @click="deleteIngredient(index)" class="delete is-small delete-ingredient"></a>
                            <p v-if="errors.has('ingredient-'+index)" class="help is-danger">{{ errors.first('ingredient-'+index) }}</p>
                        </div>

                        <p class="buttons is-right m-t-20">
                            <a @click.prevent="addIngredient()" class="is-size-7 vd-text-secondary">{{ trans('recipes.add_ingredient') }}</a>
                        </p>
                    </div>
                </div>
                <div class="column is-7">
                    <p class="m-b-15">{{ trans('recipes.preparation') }}</p>

                    <div class="vd-textarea has-label-primary m-t-0">
                        <textarea @input="preparationInput($event)"
                            v-validate.disabled="'required'"
                            name="preparation"
                            class="vd-textarea-field auto-expand"
                            :placeholder="trans('recipes.preparation_placeholder')"
                            data-min-rows="5"
                            rows="5"
                            v-html="recipe.preparation">
                        </textarea>

                        <label class="vd-placeholder is-transparent">{{ trans('recipes.preparation_placeholder') }}</label>
                    </div>
                    <p v-if="errors.has('preparation')" class="help is-danger">{{ errors.first('preparation') }}</p>
                </div>
            </div>

            <div class="columns">
                <div class="column is-12">
                    <p class="m-t-20 m-b-15">{{ trans('recipes.tags') }}</p>

                    <div class="vd-tags has-label-primary">
                        <span v-for="(tag, index) in recipe.tags" class="vd-tag is-primary">
                            {{ tag }}
                            <a class="vd-tags__delete" @click.prevent="deleteTag(index)"></a>
                        </span>
                        <div @click.prevent="focusTagInput($event)" class="vd-tags__control">
                            <input @keypress.enter.prevent="addTag($event)"
                                class="vd-tags-field"
                                :placeholder="trans('recipes.tags_placeholder')"
                                type="text" />

                            <i class="vd-tag__icon"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-12">
                    <p class="buttons is-right m-t-20">
                        <button v-if="recipeId" type="submit" class="button is-large is-primary">{{ trans('recipes.update') }}</button>
                        <button v-else type="submit" class="button is-large is-primary">{{ trans('recipes.create') }}</button>
                    </p>
                </div>
            </div>
        </form>
    </section>
</template>

<script>
    export default {
        props: ['recipeId'],

        data() {
            return {
                recipe: {
                    id: null,
                    image: null,
                    title: '',
                    preparation: '',
                    categories: [],
                    tags: [],
                    ingredients: [
                        '',
                    ],
                },
                categories: null,
                categoriesError: null,
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
                setCategoriesError() {
                    let vue = this;
                    setTimeout(function(){
                        if(!vue.recipe.categories.length){
                            vue.categoriesError = 'You must select at least one category.';
                        }else{
                            vue.categoriesError = null;
                        }
                    }, 10);
                },

            // Image
                previewImage(event) {
                    let input = event.target;

                    if(input.files && input.files[0]){
                        let reader = new FileReader();
                        reader.onload = (e) => {
                            this.recipe.image = e.target.result;
                        }
                        reader.readAsDataURL(input.files[0]);
                    }else{
                        this.recipe.image = null;
                    }
                },

            // Tags
                addTag(event) {
                    let tagFound = _.find(this.recipe.tags, function(tag) {
                        return tag.toLowerCase() === event.target.value.toLowerCase();
                    });

                    if(event.target.value && !tagFound)
                        this.recipe.tags.push(event.target.value.trim().charAt(0).toUpperCase() + event.target.value.trim().slice(1));

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

                    // if(this.recipe.ingredients.length === 0)
                        // this.addIngredient();
                },
                ingredientBlur(event, index) {
                    this.recipe.ingredients[index] = event.target.value.trim().charAt(0).toUpperCase() + event.target.value.trim().slice(1);

                    if(!event.target.value && this.recipe.ingredients.length > 1)
                        this.deleteIngredient(index);
                },

            // Recipe
                getRecipe(id) {
                    axios.get('/recipes/'+id+'/get').then(response => {
                        this.recipe = response.data;
                    }).catch(error => {
                        if(error.response && error.response.status && error.response.status === 419){
                            location.href = '/login';
                        }
                        console.info(error);
                    });
                },
                preparationInput(event) {
                    this.recipe.preparation = event.target.value;
                },
                titleBlur(event) {
                    this.recipe.title = event.target.value.trim().charAt(0).toUpperCase() + event.target.value.trim().slice(1);
                },
                store() {
                    axios.post('/recipes', this.recipe).then(response => {
                        location.href = '/recipes/'+response.data.recipe.id;
                    }).catch(error => {
                        if(error.response && error.response.status && error.response.status === 419){
                            location.href = '/login';
                        }
                        console.info(error);
                    });
                },
                update() {
                    axios.put('/recipes/'+this.recipe.id, this.recipe).then(response => {
                        location.href = '/recipes/'+response.data.recipe.id;
                    }).catch(error => {
                        if(error.response && error.response.status && error.response.status === 419){
                            location.href = '/login';
                        }
                        console.info(error);
                    });
                },

            // Validation
                validateForm() {
                    let vue = this;
                    vue.$validator.validateAll().then((validated) => {
                        if(!this.recipe.categories.length){
                            this.categoriesError = 'You must select at least one category.';
                            validated = false;
                        }else{
                            this.categoriesError = null;
                        }

                        if(validated) {
                            this.recipeId ? this.update() : this.store();
                        }else{
                            let action = vue.recipe.id ? 'update' : 'create';
                            console.info(action + ' not validated');
                            // vue.$snackbar.open({
                            //     duration: 5000,
                            //     message: 'Please correct errors before ' + action + ' recipe.',
                            //     type: 'is-danger',
                            //     queue: false,
                            //     position: 'is-top',
                            //     actionText: 'OK',
                            //     onAction: () => {
                            //         //Do something on click button
                            //     }
                            // });
                        }
                    });
                },
        },

        mounted() {
            this.getCategories();

            if(this.recipeId)
                this.getRecipe(this.recipeId);
        }
    }
</script>
