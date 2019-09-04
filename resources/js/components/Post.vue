<template>
    <div class='row'>
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h1>My Posts</h1>
                </div>
            </div>
            <div class="card-body">
                <form @submit.prevent="createPost">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="formData.name">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" v-model="formData.description" rows="6"></textarea>
                    </div>
                    <div>
                        <label>Select Categories</label>
                        {{ selectedCategories }}
                        <select v-model="selectedCategories" multiple>
                            <option v-for="(category,index) in categoryList"
                                :key="index"
                                :value="category.id">
                                {{ category.category }}
                            </option>
                        </select>
                    </div>
                    <div style="text-align: center">
                        <button data-inline="true" type="submit" class="btn btn-primary">Add post</button>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <h4>All Tasks</h4>
                <ul class="list-group">
                    <p class="no-post" v-if='list.length === 0'>There are no tasks yet!</p>
                    <li class="list-group-item" v-for="(formData, index) in list" :key="index">
                        <div class="card">
                            <div class="card-header">
                                <h3>{{ formData.name}}</h3>
                            </div>
                            <div class="card-body">
                                <h5>{{ formData.description }}</h5><hr>
                                <label class="categories">Categories:</label>
                                <div v-for="(category, index) in formData.categories" :key="index">
                                    {{ category.category}}
                                </div>
                            </div>
                        </div>
                        <div style="text-align: center; margin-top:8px;">
                            <a :href="'/adminhome/'+formData.id+'/edit'" class="btn btn-success btn-xs" data-inline="true">Edit</a>
                            <button @click="deletePost(formData.id,index)" class="btn btn-danger btn-xs" data-inline="true">Delete</button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        postData: {
            type: Array,
            required: true
        },
    },
    data() {
        return {
            selectedCategories: [],
            list: [],
            categoryList: [],
            formData: {
                name: '',
                description: '',
                // category_id: '',
                category: '',
                // categories_id: [],
            },
        };
    },
    mounted() {
        console.log('mounted');
        if(this.postData) {
            this.list = this.postData
            this.fetchCategory()
        }
        this.fetchCat()
    },
    methods: {
        async fetchCat () {
            let res = await axios.get('/posts/3/filter')
            if (res.data) {
                console.log(res.data)
            }
        },
        async fetchCategory () {
            let res = await axios.get('/category')
            if (res.data) {
                this.categoryList = res.data.categories
            }
        },
        async createPost() {
            let data = {
                name: this.formData.name,
                description: this.formData.description,
                categories: this.selectedCategories
            }
            console.log(data);
            axios.post('/adminhome', data)
                .then((res) => {
                    this.formData.name = '';
                    this.formData.description = '';
                    this.formData.categoryList = '';
                    this.list.push(res.data.formData)
                })
                .catch((err) => console.error(err));
        },
        deletePost(id,index) {
            axios.delete('adminhome/' +id)
                .then((res) => {
                    this.list.splice(index,1)
                })
                .catch((err) => console.error(err));
        },
    }
};
</script>
<style >
    .card {
        width: 100%;
    }
    .categories {
        color: black;
        text-decoration: none;
        margin-bottom: 5px;
    }
    .cat-style {
        color: black;
    }
    .list-group-item {
        margin-top: 30px;
    }
</style>
