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

                        <form class="row g-2" @submit.prevent="updatePost" enctype="multipart/form-data">

                                <div class="form-group mb-2 col-6">
                                    <label>Title</label><span class="text-danger">*</span> <span class="text-danger"
                                                                                                 v-if="err.title && !books.title">{{err.title}}</span>
                                    <input :class="{ 'border-danger': err.title && !books.title }" class="form-control"
                                           placeholder="Enter Title" type="text" v-model="books.title">
                                </div>
                                <div class="form-group mb-2 col-6">
                                    <label>Author</label><span class="text-danger">*</span> <span class="text-danger"
                                                                                                  v-if="err.author && !books.author">{{err.author}}</span>
                                    <input :class="{ 'border-danger': err.author && !books.author }" class="form-control" placeholder="Enter Author"
                                           type="text" v-model="books.author">
                                </div>
                                <div class="form-group mb-2 col-6">
                                    <label>Genre</label><span class="text-danger">*</span> <span class="text-danger"
                                                                                                 v-if="err.genre && !books.genre">{{err.genre}}</span>
                                    <input :class="{ 'border-danger': err.genre&& !books.genre }" class="form-control"
                                           placeholder="Enter Genre" type="text" v-model="books.genre">
                                </div>

                                <div class="form-group mb-2 col-6">
                                    <label>Isbn</label><span class="text-danger">*</span> <span class="text-danger"
                                                                                                v-if="err.isbn && !books.isbn">{{err.isbn}}</span>
                                    <input :class="{ 'border-danger': err.isbn && !books.isbn }" class="form-control"
                                           placeholder="Enter Isbn" type="text"
                                           v-model="books.isbn">
                                </div>
                                <div class="form-group mb-2 col-6">
                                    <label>Published</label><span class="text-danger">*</span> <span class="text-danger"
                                                                                                     v-if="err.published && !books.published">{{err.published}}</span>
                                    <input :class="{ 'border-danger': err.published && !books.published }"
                                           class="form-control"
                                           placeholder="Enter Published" type="date"
                                           v-model="books.published">
                                </div>
                                <div class="form-group mb-2 col-6">
                                    <label>Publisher</label><span class="text-danger">*</span> <span class="text-danger"
                                                                                                     v-if="err.publisher && !books.publisher">{{err.publisher}}</span>
                                    <input :class="{ 'border-danger': err.publisher && !books.publisher }" class="form-control" placeholder="Enter Publisher"
                                           type="text"
                                           v-model="books.publisher">
                                </div>
                                <div class="form-gorup mb-2 col-6">
                                    <label>Image</label> <span class="text-danger" v-if="err.file">{{err.file}}</span>
                                    <input :class="{ 'border-danger': err.file }" class="form-control mb-2" type="file"
                                           v-on:change="onChange">

                                    <div v-if="books.img">
                                        <img height="100" v-bind:src="imgPreview" width="100"/>
                                    </div>
                                </div>
                                <div class="form-group mb-2 col-12">
                                    <label>Description</label><span class="text-danger">*</span> <span class="text-danger"
                                                                                                       v-if="err.description && !books.description">{{err.description}}</span>
                                    <textarea :class="{ 'border-danger': err.description && !books.description }" class="form-control" placeholder="Enter Description"
                                              rows="3"
                                              v-model="books.description"></textarea>
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
                books: {},
                strSuccess: '',
                strError: '',
                err: {
                },
                imgPreview: null
            }
        },

        created() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get(`/api/books/edit/${this.$route.params.id}`)
                    .then(response => {
                        var data = response.data.data;
                        this.books = data;
                        this.books.img = "/img/" + data['image'];
                        this.imgPreview = this.books.img;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            })
        },
        methods: {
            onChange(e) {
                this.books.img = e.target.files[0];
                let reader = new FileReader();
                reader.addEventListener("load", function () {
                    this.imgPreview = reader.result;
                }.bind(this), false);

                if (this.books.img) {
                    if (/\.(jpe?g|png|gif)$/i.test(this.books.img.name)) {
                        reader.readAsDataURL(this.books.img);
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
                    };

                    const formData = new FormData();
                    for (var key in this.books) {
                        if (key === 'img') {
                            formData.append('file', this.books.img);
                        } else {
                            formData.append(key, this.books[key]);
                        }
                    }

                    this.$axios.post(`/api/books/update/${this.$route.params.id}`, formData, config)
                        .then(response => {
                            existingObj.err = "";
                            existingObj.strSuccess = response.data.message;
                            window.location.href = '/books';
                        })
                        .catch(function (error) {
                            existingObj.strSuccess = "";
                            $.each(error.response.data.errors, function (key, value) {
                                existingObj.err[key] = value[0];
                            });
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
