<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h3 class="card-title">Events List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="float-right">
                                        <b-button-group size="sm">
                                            <b-button variant="success" @click="getEvents">
                                                <b-icon icon="arrow-clockwise"></b-icon>
                                                Refresh
                                            </b-button>
                                            <b-button variant="primary" @click="addEvent">
                                                <b-icon icon="plus"></b-icon>
                                                Add Event
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
                                    :items="events"
                                    :fields="fields"
                                    responsive="sm"
                                    :per-page="perPage"
                                    show-empty
                                    empty-text="There no events Found"
                                    :current-page="currentPage"
                                    primary-key="id"
                                    :busy="isBusy"
                                    :sort-desc.sync="sortDesc"
                                    :filter="filter"
                                    :bordered="true"
                                    :filter-included-fields="filterOn"
                                    @filtered="onFilteredEvents"
                                    ref="carMakeTable">
                                    <template v-slot:cell(index)="item">
                                        {{item.index+1}}
                                    </template>

                                    <template v-slot:cell(location)="data">
                                        {{data.value.name}}
                                    </template>

                                    <template v-slot:cell(image)="row">
                                        <img class="rounded-circle avatar-xs" :src="row.value" alt=""
                                             style="width: 50px; height: 50px;" title="click to see photo">
                                    </template>
                                    <template v-slot:table-busy>
                                        <div class="text-center  my-2">
                                            <b-spinner class="align-middle text-primary"></b-spinner>
                                            <strong>Loading Events...</strong>
                                        </div>
                                    </template>
                                    <template v-slot:cell(actions)="row">
                                        <div class="text-center">
                                            <b-dropdown size="sm" text="Actions" class="m-2">
                                                <b-dropdown-item-button>Edit</b-dropdown-item-button>
                                                <b-dropdown-item-button>View</b-dropdown-item-button>
                                                <b-dropdown-item-button>Delete</b-dropdown-item-button>
                                            </b-dropdown>
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
        name: "Events",
        data() {
            return {
                isBusy: false,
                fields: [
                    {
                        label: '#',
                        key: 'Index'
                    },
                    {
                        key: 'name',
                        label: 'Name'
                    },
                    {
                        key: 'location',
                        label: 'Location'
                    },
                    {
                        key: 'prices',
                        label: 'Ticket Prices'
                    },
                    {
                        key: 'reservation',
                        label: 'Reservation'
                    },
                    {
                        key: 'created_at',
                        label: 'Created At'
                    },
                    {
                        key: 'happening_date',
                        label: 'Happening Date'
                    },
                    {
                        key: 'Actions'
                    }
                ],
                totalRows: 1,
                currentPage: 1,
                perPage: 10,
                pageOptions: [5, 10, 25, 50, 100],
                filter: null,
                filterOn: [],
                sortDesc: false,
                events: [],
            }
        },
        computed: {
            rows() {
                return this.events.length;
            },
        },
        mounted() {
            this.getEvents();
        },
        methods: {
            getEvents() {
                this.isBusy = true;
                axios.get('/admin/get-events').then((response) => {
                    this.isBusy = false;
                    this.events = response.data;
                })
            },
            addEvent() {
                window.location.href = '/admin/add-event'
            },
            onFilteredEvents(filteredItems) {
                this.totalRows = filteredItems.length;
                this.currentPage = 1;
            },
        }
    }
</script>

<style scoped>

</style>
