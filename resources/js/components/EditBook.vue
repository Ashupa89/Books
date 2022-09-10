<template>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-right">
                        <div class="d-flex justify-content-between pb-2 mb-2">
                            <h3 class="card-title">Edit Book</h3>
                            <div>
                                <router-link :to="{name: 'books'}" class="btn btn-outline-secondary">Go Back
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>{{strSuccess}}</strong>
                        </div>

                        <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>{{strError}}</strong>
                        </div>
                        <form class="row g-2" @submit.prevent="updatePost" enctype="multipart/form-data">
                            <div class="form-group mb-2 col-6">
                                <label>Title</label><span class="text-danger"> *</span>
                                <input type="text" class="form-control" v-model="title" placeholder="Enter Title">
                            </div>
                            <div class="form-group mb-2 col-6">
                                <label>Author</label><span class="text-danger"> *</span>
                                <input type="text" class="form-control" v-model="author" placeholder="Enter Author">
                            </div>
                            <div class="form-group mb-2 col-6">
                                <label>Genre</label><span class="text-danger"> *</span>
                                <input type="text" class="form-control" v-model="genre" placeholder="Enter Genre">
                            </div>

                            <div class="form-group mb-2 col-6">
                                <label>Isbn</label><span class="text-danger"> *</span>
                                <input type="text" class="form-control" v-model="isbn" placeholder="Enter Isbn">
                            </div>
                            <div class="form-group mb-2 col-6">
                                <label>Published</label><span class="text-danger"> *</span>
                                <input type="date" class="form-control" v-model="published"
                                       placeholder="Enter Published">
                            </div>
                            <div class="form-group mb-2 col-6">
                                <label>Publisher</label>
                                <input type="text" class="form-control" v-model="publisher"
                                       placeholder="Enter Publisher">
                            </div>
                            <div class="form-gorup mb-2 col-6">
                                <label>Image</label><span class="text-danger"> *</span>
                                <input type="file" class="form-control mb-2" v-on:change="onChange">

                                <div v-if="img">
                                    <img v-bind:src="imgPreview" width="100" height="100"/>
                                </div>
                            </div>
                            <div class="form-group mb-2 col-12">
                                <label>Description</label><span class="text-danger"> *</span>
                                <textarea class="form-control" rows="3" v-model="description"
                                          placeholder="Enter Description"></textarea>
                            </div>
                            <div class="form-group mb-2 col-12">
                                <button type="submit" class="btn btn-primary mt-4 mb-4 col-2"> Update Book</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                id: '',
                title: '',
                author: '',
                genre: '',
                description: '',
                isbn: '',
                img: '',
                published: '',
                publisher: '',
                strSuccess: '',
                strError: '',
                imgPreview: null
            }
        },

        created() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get(`/api/books/edit/${this.$route.params.id}`)
                    .then(response => {
                        var data = response.data.data;
                        this.title = data['title'];
                        this.description = data['description'];
                        this.author = data['author'];
                        this.genre = data['genre'];
                        this.isbn = data['isbn'];
                        this.published = data['published'];
                        this.publisher = data['publisher'];
                        this.img = "/img/" + data['image'];
                        this.imgPreview = this.img;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            })
        },
        methods: {
            onChange(e) {
                this.img = e.target.files[0];
                let reader = new FileReader();
                reader.addEventListener("load", function () {
                    this.imgPreview = reader.result;
                }.bind(this), false);

                if (this.img) {
                    if (/\.(jpe?g|png|gif)$/i.test(this.img.name)) {
                        reader.readAsDataURL(this.img);
                    }
                }
            },
            updatePost(e) {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    let existingObj = this;
                    const config = {
                        headers: {
                            'content-type': 'multipart/form-data'
                        }
                    }

                    const formData = new FormData();
                    formData.append('title', this.title);
                    formData.append('description', this.description);
                    formData.append('author', this.author);
                    formData.append('genre', this.genre);
                    formData.append('isbn', this.isbn);
                    formData.append('published', this.published);
                    formData.append('publisher', this.publisher);
                    formData.append('file', this.img);

                    this.$axios.post(`/api/books/update/${this.$route.params.id}`, formData, config)
                        .then(response => {
                            existingObj.strError = "";
                            existingObj.strSuccess = response.data.success;
                        })
                        .catch(function (error) {
                            existingObj.strSuccess = "";
                            existingObj.strSuccess = "";
                            var err = "";
                            error.response.data.data.forEach(function (key) {
                                err += key;
                            });
                            existingObj.strError = err;
                        });
                });
            }

        },
        beforeRouteEnter(to, from, next) {
            if (!window.Laravel.isLoggedin) {
                window.location.href = "/login";
            } else if (!window.Laravel.isAdmin) {
                window.location.href = "/login";
            }
            next();
        }
    }

</script>
