<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h3 class="card-title">Staff List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="float-right">
                                        <b-button-group size="sm">
                                            <b-button variant="success" @click="getStaff">
                                                <b-icon icon="arrow-clockwise"></b-icon>
                                                Refresh
                                            </b-button>
                                            <b-button variant="primary" @click="openAddStaffModal">
                                                <b-icon icon="plus"></b-icon>
                                                Add Staff
                                            </b-button>
                                        </b-button-group>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-12 col-md-6">
                                    <div id="make-table_length" class="dataTables_length">
                                        <label class="d-inline-flex align-items-center">
                                            Show&nbsp;
                                            <b-form-select v-model="perPage" size="sm"
                                                           :options="pageOptions"></b-form-select>&nbsp;entries
                                        </label>
                                    </div>
                                </div>
                                <!-- Search -->
                                <div class="col-sm-12 col-md-6">
                                    <div id="make-table_filter" class="dataTables_filter text-md-right">
                                        <label class="d-inline-flex align-items-center">
                                            Search:
                                            <b-form-input
                                                v-model="filter"
                                                type="search"
                                                placeholder="Search..."
                                                class="form-control form-control-sm ml-2"
                                            ></b-form-input>
                                        </label>
                                    </div>
                                </div>
                                <!-- End search -->
                            </div>
                            <!-- Table -->
                            <div class="table-responsive mb-0">
                                <b-table
                                    foot-clone
                                    :items="staff"
                                    :fields="fields"
                                    responsive="sm"
                                    :per-page="perPage"
                                    show-empty
                                    empty-text="There no staff Found"
                                    :current-page="currentPage"
                                    primary-key="id"
                                    :busy="isBusy"
                                    :sort-desc.sync="sortDesc"
                                    :filter="filter"
                                    :bordered="true"
                                    :filter-included-fields="filterOn"
                                    @filtered="onFilteredStaff"
                                    ref="carMakeTable">
                                    <template v-slot:cell(index)="item">
                                        {{item.index+1}}
                                    </template>


                                    <template v-slot:cell(avatar)="data">
                                        <span class="fa fa-user fa-2x"></span>
                                    </template>

                                    <template v-slot:cell(created_at)="data">
                                        {{moment(data.value).format("MMMM Do YYYY")}}
                                    </template>


                                    <template v-slot:table-busy>
                                        <div class="text-center  my-2">
                                            <b-spinner class="align-middle text-primary"></b-spinner>
                                            <strong>Loading Events...</strong>
                                        </div>
                                    </template>
                                </b-table>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="dataTables_paginate paging_simple_numbers float-right">
                                        <ul class="pagination pagination-rounded mb-0">
                                            <!-- pagination -->
                                            <b-pagination v-model="currentPage" :total-rows="rows"
                                                          :per-page="perPage"></b-pagination>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</template>

<script>
    export default {
        name: "Staff",
        data() {
            return {
                isBusy: false,
                fields: [
                    {
                        label: '#',
                        key: 'Index'
                    },
                    {
                        key: 'avatar',
                        label: 'Avatar'
                    },
                    {
                        key: 'name',
                        label: 'Name'
                    },
                    {
                        key: 'email',
                        label: 'Email'
                    },
                    {
                        key: 'created_at',
                        label: 'Created At'
                    },
                ],
                totalRows: 1,
                currentPage: 1,
                perPage: 10,
                pageOptions: [5, 10, 25, 50, 100],
                filter: null,
                filterOn: [],
                sortDesc: false,
                staff: [],
            }
        },
        computed: {
            rows() {
                return this.staff.length;
            },
        },
        mounted() {
            this.getStaff();
        },
        methods: {
            getStaff() {
                this.isBusy = true;
                axios.get('/admin/get-staff').then((response) => {
                    this.isBusy = false;
                    this.staff = response.data;
                }).catch((error) => {
                    this.isBusy = false;
                })
            },
            openAddStaffModal() {

            },
            onFilteredStaff(filteredItems) {
                this.totalRows = filteredItems.length;
                this.currentPage = 1;
            },
        }
    }
</script>

<style scoped>

</style>
