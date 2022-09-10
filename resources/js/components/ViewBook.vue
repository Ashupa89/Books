<template>
    <div class="container emp-profile">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <div class="d-flex justify-content-between pb-2 mb-2">
                                <h3 class="card-title">Book Information</h3>
                                <div>
                                    <router-link :to="{name: 'books'}" class="btn btn-outline-secondary">Go Back
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <form method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="profile-img">
                                        <img v-bind:src="img ? '/img/'+img :'/img_logo.jpeg'" alt="">
                                        <div class="file btn btn-lg btn-primary">
                                            Image
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="profile-head">
                                        <h5>
                                            {{title}}
                                        </h5>
                                        <h6>
                                            {{description}}
                                        </h6>
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                                   role="tab" aria-controls="home" aria-selected="true">About</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">

                                </div>
                                <div class="col-md-8">
                                    <div class="tab-content profile-tab" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home" role="tabpanel"
                                             aria-labelledby="home-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Author</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>{{author}}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Published Date</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>{{published}}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Pushlisher</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>{{publisher}}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Genre</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>{{genre}}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Isbn</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>{{isbn}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
            this.$axios.get(`/api/books/view/${this.$route.params.id}`)
                .then(response => {
                    var data = response.data.data;
                    this.title = data['title'];
                    this.description = data['description'];
                    this.author = data['author'];
                    this.genre = data['genre'];
                    this.isbn = data['isbn'];
                    this.published = data['published'];
                    this.publisher = data['publisher'];
                    this.img = data['image'];
                    this.imgPreview = this.img;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        methods: {},
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
