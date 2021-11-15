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
                            <div class="float-right mb-2">
                                <b-button-group size="sm">
                                    <b-button variant="success">
                                        <b-icon icon="arrow-clockwise"></b-icon>
                                        Refresh
                                    </b-button>
                                    <b-button variant="primary" @click="openAddEventModal">
                                        <b-icon icon="plus"></b-icon>
                                        Add Event
                                    </b-button>
                                </b-button-group>
                            </div>
                            <b-table
                                foot-clone
                                :items="recipes"
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

                                    </div>
                                </template>
                            </b-table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>

        <!--  add event modal-->
        <ValidationObserver ref="addEventObserver" v-slot="{ handleSubmit }">
            <b-modal ref="addEvent" centered title="Add Event" :no-close-on-backdrop="true"
                     @ok.prevent="handleSubmit(addEvent)" @show="resetModal" @hidden="resetModal">
                <ValidationProvider rules="required|email" name="Email" v-slot="{ valid, errors }">
                    <b-form-group
                        label="Name:"
                    >
                        <b-form-input
                            type="email"
                            v-model="form.name"
                            :state="errors[0] ? false : (valid ? true : null)"
                            placeholder="Enter Name"
                        ></b-form-input>
                        <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                </ValidationProvider>

                <template v-slot:modal-footer="{ ok, cancel}">
                    <b-button size="sm" variant="danger" @click="cancel()">
                        Cancel
                    </b-button>
                    <b-button size="sm" variant="primary" @click="ok()">
                        Add
                    </b-button>
                </template>
            </b-modal>
        </ValidationObserver>
        <!-- /.container-fluid -->
    </section>
</template>

<script>
    export default {
        name: "Events",
        data() {
            return {
                form: {name: '', image: '', location: '', happening_date: ''},
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
                recipes: [],
            }
        },
        computed: {
            rows() {
                return this.recipes.length;
            },
        },
        methods: {
            openAddEventModal() {
                this.$refs['addEvent'].show();
            },
            addEvent() {

            },
            resetModal() {

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
