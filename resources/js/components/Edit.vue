<template>
    <div class="card">
        <div class="card-header">
            <h1>Edit Posts</h1>
        </div>
        <div class="card-body">
            <form @submit.prevent="updatePost">
                <div class="form-group">
                    <label for="">Post Title</label>
                    <input type="text" v-model="formData.name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Post Description</label>
                    <textarea type="text" v-model="formData.description" class="form-control" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label>Selected Categories</label>
                    <div
                        v-for="(category,index) in formData.categories"
                        :key="index"
                    >{{ category.category }}
                    </div>
                </div>
                <div class="form-group">
                        <label>Select Category</label>
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
                    <button data-inline="true" type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
 </template>
 <script>
 export default {
    props:{
        post:{
            type:Object,
            required:true
        }
    },
    data () {
        return {
            list:[],
            categoryList: [],
            selectedCategories: [],
            formData: {
                name: '',
                description: '',
            }
        }
    },
    mounted () {
        if(this.post)
        {
            this.formData.name = this.post.name;
            this.formData.description = this.post.description;
            this.formData.categories = this.post.categories;
            // this.selectedCategories = this.post.selectedCategories;
            this.fetchCategory ();
        }
    },
    methods: {
        async fetchData (id) {
            let res = await axios.get('/adminhome/' + this.$route.params.id + '/edit')
            if (res.data) {
               this.formData.name = res.data.PostData.name
               this.formData.description = res.data.PostData.description
               this.formData.categories = res.data.PostData.categories
            }
        },
        async updatePost (e) {
            let data = {
                name: this.formData.name,
                description: this.formData.description,
                categories: this.selectedCategories
            }
            let res = await axios.put('/adminhome/' + this.post.id, data)
                .then((res) => {
                    this.formData.name = '';
                    this.formData.description = '';
                    this.formData.categories = '';
                    this.list.push(res.data.formData)
                })
                .catch((err) => console.error(err));
        },
        async fetchCategory () {
            let res = await axios.get('/category')
            if (res.data) {
                this.categoryList = res.data.categories
            }
        },
    }
 }
</script>

