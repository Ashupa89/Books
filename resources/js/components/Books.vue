<template>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-right">
                        <div class="d-flex justify-content-between pb-2 mb-2">
                            <h3 class="card-title">Books List</h3>
                            <div>
                                <router-link :to="{name: 'addbook'}" class="text-right btn btn-outline-primary">Add
                                    Book
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            <strong>{{strSuccess}}</strong>
                        </div>

                        <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            <strong>{{strError}}</strong>
                        </div>

                        <form class="row g-2" @submit.prevent="filterBooks" enctype="multipart/form-data">
                            <div class="form-group mb-4">
                                <label>Title<span class="text-danger"> *</span>
                                    <input type="text" placeholder="Title" v-model="filter.title"
                                           class="form-control form-control-sm">
                                </label>
                                <label>Author<span class="text-danger"> *</span>
                                    <input type="text" placeholder="Author" v-model="filter.author"
                                           class="form-control form-control-sm">
                                </label>
                                <label>Published Date<span class="text-danger"> *</span>
                                    <input type="date" placeholder="Published Date" v-model="filter.publish_date"
                                           class="form-control form-control-sm">
                                </label>
                                <label>Isbn<span class="text-danger"> *</span>
                                    <input type="text" placeholder="Isbn" v-model="filter.isbn"
                                           class="form-control form-control-sm">
                                </label>
                                <label>Genre<span class="text-danger"> *</span>
                                    <input type="text" placeholder="Genre" v-model="filter.genre"
                                           class="form-control form-control-sm">
                                </label>
                                <button type="submit" class="btn btn-primary"> Filter Book</button>
                            </div>
                        </form>
                        <div class="form-group mb-2">
                            <label align="left">Search<span class="text-danger"> *</span>
                                <input type="text" @keyup="list" placeholder="Search" v-model="search"
                                       class="form-control form-control-sm">
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
                                <tr v-for="(book,index) in users.data" :key="index">
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
                                    <td><img v-if="book.image" v-bind:src="'/img/'+ book.image" height="64" width="48"
                                             alt=""></td>
                                    <td>{{book.published }}</td>
                                    <td>{{book.publisher }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <router-link :to="{name: 'editbook', params: { id: book.id }}"
                                                         class="btn btn-success">Edit
                                            </router-link>
                                            <button class="btn btn-danger" @click="deleteBook(book.id)">Delete</button>
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
                        <pagination align="center" :data="users" @pagination-change-page="list"></pagination>
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
                strError: '',
            }
        },
        mounted() {
            this.list()
        },
        methods: {

            async list(page = 1) {
                await axios.get(`/api/books?page=${page}&search=${this.search}`).then(({data}) => {
                    this.users = data
                }).catch(({response}) => {
                    console.error(response)
                })
            },
            async filterBooks(page = 1) {
                let existingObj = this;
                await axios.post(`/api/books?page=${page}`,
                    this.filter).then(({data}) => {
                    this.users = data
                }).catch(function (error) {
                    existingObj.strSuccess = "";
                    existingObj.strError = error.response.data.message;
                });
            },
            deleteBook(id) {
                let existingObj = this;

                if (confirm("Do you really want to delete this data?")) {
                    this.$axios.delete(`/api/books/delete/${id}`)
                        .then(response => {

                            let i = this.users.map(item => item.id).indexOf(id); // find index of your object
                            this.users.splice(i, 1);
                            existingObj.strError = "";
                            existingObj.strSuccess = response.data.success;

                        })
                        .catch(function (error) {
                            existingObj.strError = "";
                            existingObj.strSuccess = error.response.data.message;
                        });
                }
            }
        }, beforeRouteEnter(to, from, next) {
            if (!window.Laravel.isLoggedin) {
                window.location.href = "/";
            } else if (!window.Laravel.isAdmin) {
                window.location.href = "/";
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
