<template>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-right">
                        <div class="d-flex justify-content-between pb-2 mb-2">
                            <h3 class="card-title">Books List</h3>
                            <div>
                                <router-link :to="{name: 'addbook'}" class="text-right btn btn-outline-primary"
                                             v-if="permission">Add
                                    Book
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="strSuccess">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert"
                                    type="button"></button>
                            <strong>{{strSuccess}}</strong>
                        </div>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="strError">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert"
                                    type="button"></button>
                            <strong>{{strError}}</strong>
                        </div>

                        <form @submit.prevent="filterBooks" class="row g-2" enctype="multipart/form-data">
                            <div class="form-group  col-2">
                                <label>Title<span class="text-danger"> *</span>
                                    <input class="form-control form-control-sm" placeholder="Title" type="text"
                                           v-model="filter.title">
                                </label>
                                <span class="text-danger"
                                      v-if="err.title">{{err.title}}</span>
                            </div>
                            <div class="form-group col-2">
                                <label>Author<span class="text-danger"> *</span>
                                    <input class="form-control form-control-sm" placeholder="Author" type="text"
                                           v-model="filter.author">
                                </label>
                                <span class="text-danger"
                                      v-if="err.author">{{err.author}}</span>
                            </div>
                            <div class="form-group col-2">

                                <label>Published Date<span class="text-danger"> *</span>
                                    <input class="form-control form-control-sm" placeholder="Published Date" type="date"
                                           v-model="filter.publish_date">
                                </label>
                                <span class="text-danger"
                                      v-if="err.publish_date">{{err.publish_date}}</span>
                            </div>
                            <div class="form-group  col-2">
                                <label>Isbn<span class="text-danger"> *</span>
                                    <input class="form-control form-control-sm" placeholder="Isbn" type="text"
                                           v-model="filter.isbn">
                                </label>
                                <span class="text-danger" v-if="err.isbn">{{err.isbn}}</span>
                            </div>
                            <div class="form-group  col-2">
                                <label>Genre<span class="text-danger"> *</span>
                                    <input class="form-control form-control-sm" placeholder="Genre" type="text"
                                           v-model="filter.genre">
                                </label>
                                <span class="text-danger"
                                      v-if="err.genre">{{err.genre}}</span>
                            </div>
                            <div class="form-group col-2" style="margin: auto">
                                <button class="btn btn-primary" type="submit"> Filter Book</button>
                            </div>
                        </form>
                        <div align="right" class="form-group mb-2 col-12">
                            <label align="left">Search<span class="text-danger"> *</span>
                                <input @keyup="list" class="form-control form-control-sm" placeholder="Search"
                                       type="text"
                                       v-model="search">
                            </label>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Genre</th>
                                    <th>Description</th>
                                    <th>Isbn</th>
                                    <th>Image</th>
                                    <th>Published</th>
                                    <th>Publisher</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody v-if="users && users.data">
                                <tr :key="index" v-for="(book,index) in users.data">
                                    <td>{{book.id }}</td>
                                    <td>
                                        <router-link :to="{name: 'viewbook', params: { id: book.id }}"
                                        >{{book.title }}
                                        </router-link>
                                    </td>
                                    <td>{{book.author }}</td>
                                    <td>{{book.genre }}</td>
                                    <td>{{book.description }}</td>
                                    <td>{{book.isbn }}</td>
                                    <td><img alt="" height="64" v-bind:src="'/img/'+ book.image" v-if="book.image"
                                             width="48"></td>
                                    <td>{{book.published }}</td>
                                    <td>{{book.publisher }}</td>
                                    <td>
                                        <div class="btn-group" role="group" v-if="permission">
                                            <router-link :to="{name: 'editbook', params: { id: book.id }}"
                                                         class="btn btn-success">Edit
                                            </router-link>
                                            <button @click="deleteBook(book.id)" class="btn btn-danger"
                                                    v-if="permission">Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                                <tbody v-else>
                                <tr>
                                    <td align="center" colspan="3">No record found.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination :data="users" @pagination-change-page="list" align="center"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import pagination from 'laravel-vue-pagination'

    export default {
        name: "users",
        components: {
            pagination
        },
        data() {
            return {
                users: {
                    type: Object,
                    default: null
                },
                search: "",
                filter: {
                    title: '',
                    author: '',
                    publishdate: '',
                    genre: '',
                    isbn: ''
                },
                strSuccess: '',
                err: {},
                permission: window.Laravel.isAdmin
            }
        },
        mounted() {
            this.list()
        },
        methods: {

            async list(page = 1) {
                await axios.get(`/api/books?page=${page}&search=${this.search}`).then(({data}) => {
                    this.users = data.data;
                }).catch(({response}) => {
                    console.log(response)
                })
            },
            async filterBooks(page = 1) {
                let existingObj = this;
                await axios.post(`/api/books?page=${page}`,
                    this.filter).then(({data}) => {
                    this.users = data.data;
                }).catch(function (error) {
                    existingObj.strSuccess = "";
                    $.each(error.response.data.errors, function (key, value) {
                        existingObj.err[key] = value[0];
                    });
                });
            },
            deleteBook(id) {
                let existingObj = this;

                if (confirm("Do you really want to delete this data?")) {
                    this.$axios.delete(`/api/books/delete/${id}`)
                        .then(response => {

                            let i = this.users.data.map(item => item.id).indexOf(id); // find index of your object
                            this.users.data.splice(i, 1);
                            existingObj.strError = "";
                            existingObj.strSuccess = response.data.message;

                        })
                        .catch(function (error) {
                            existingObj.strError = "";
                            existingObj.strSuccess = error.response.data.message;
                        });
                }
            }
        }, beforeRouteEnter(to, from, next) {
            if (!window.Laravel.isLoggedin) {
                window.location.href = "/login";
            }
            next();
        }
    }
</script>

<style scoped>
    .pagination {
        margin-bottom: 0;
    }
</style>
