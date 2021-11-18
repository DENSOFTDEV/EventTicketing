<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h3 class="card-title">Overview</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <b-tabs content-class="mt-3">
                                <b-tab title="Event Details" active>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img :src="event.poster_url" style="max-height: 150px;"
                                                 class="img-thumbnail" alt="">
                                        </div>
                                        <div class="col-md-9">
                                            <h4>{{event.name}}</h4>
                                            <p style="font-style: italic; font-size: 18px">##{{event.hashTag}}</p>
                                            <div>
                                                <i class="fas fa-map-marker-alt fa-2x text-success mr-2"></i>
                                                <h5 class="d-inline-block">{{event.location.name}}</h5>
                                                <p class="d-inline-block">{{event.venue}}</p>
                                            </div>
                                            <div>
                                                <i class="fas fa-clock fa-2x text-success mr-2"></i>
                                                <h5 class="d-inline-block">{{date}}</h5>
                                                <p class="d-inline-block text-success" style="font-size: 16px">
                                                    ({{fromNow}})</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h4>Ticket Pricing</h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p class="text-warning" style="font-size: 13px; font-style: italic">Add
                                                ticket types in settings before adding prices on
                                                the table</p>
                                            <a class="btn btn-primary btn-sm" href="/admin/settings">
                                                Add Ticket Types
                                            </a>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row my-2">
                                                <div class="col-md-12">
                                                    <div class="float-right">
                                                        <b-button-group size="sm">
                                                            <b-button variant="success" @click="getTicketPricing">
                                                                <b-icon icon="arrow-clockwise"></b-icon>
                                                                Refresh
                                                            </b-button>
                                                            <b-button variant="primary" @click="showTicketPricingModal">
                                                                <b-icon icon="plus"></b-icon>
                                                                Add Pricing
                                                            </b-button>
                                                        </b-button-group>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="isLoading" class="row">
                                                <div class="col-md-12 text-center">
                                                    <p>Loading:</p>
                                                    <b-icon icon="arrow-clockwise" animation="spin"
                                                            font-scale="4"></b-icon>
                                                </div>
                                            </div>
                                            <table v-else class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Ticket Type</th>
                                                    <th scope="col">Pricing</th>
                                                    <th scope="col">Reservations</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody v-if="ticketPrices.length > 0">
                                                <tr v-for="(ticketPrice,index) in ticketPrices" :key="ticketPrice.id">
                                                    <th scope="row">{{index +1}}</th>
                                                    <td>{{ticketPrice.ticket.name}}</td>
                                                    <td>{{ticketPrice.price}}</td>
                                                    <td>{{ticketPrice.reservation_no}}</td>
                                                    <td>
                                                        <div class="text-center">
                                                            <b-dropdown variant="primary" size="sm" text="Actions"
                                                                        class="m-2">
                                                                <b-dropdown-item-button
                                                                    @click="showTicketPricingEditingModal(ticketPrice)">
                                                                    Edit
                                                                </b-dropdown-item-button>
                                                                <b-dropdown-item-button
                                                                    @click="deleteTicketPricing(ticketPrice)">
                                                                    Delete
                                                                </b-dropdown-item-button>
                                                            </b-dropdown>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                                <tbody v-else>
                                                <tr>
                                                    <td colspan="5" class="text-center">No pricing found</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </b-tab>
                                <b-tab title="Tickets">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="float-right">
                                                <b-button-group size="sm">
                                                    <b-button variant="success" @click="getTickets">
                                                        <b-icon icon="arrow-clockwise"></b-icon>
                                                        Refresh
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
                                            :items="tickets"
                                            :fields="fields"
                                            responsive="sm"
                                            :per-page="perPage"
                                            show-empty
                                            empty-text="There no tickets Found"
                                            :current-page="currentPage"
                                            primary-key="id"
                                            :busy="isBusy"
                                            :sort-desc.sync="sortDesc"
                                            :filter="filter"
                                            :bordered="true"
                                            :filter-included-fields="filterOn"
                                            @filtered="onFilteredTickets"
                                            ref="carMakeTable">
                                            <template v-slot:cell(index)="item">
                                                {{item.index+1}}
                                            </template>

                                            <template v-slot:cell(user)="data">
                                                {{data.value.name}}
                                            </template>

                                            <template v-slot:cell(type)="data">
                                                {{data.item.ticket_pricing.ticket.name}}
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
                                </b-tab>
                            </b-tabs>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>

        <!--        add pricing modal-->
        <ValidationObserver ref="addTicketPricingObserver" v-slot="{ handleSubmit }">
            <b-modal ref="addTicketPricingModal" size="sm" centered title="Add Ticket Pricing"
                     :no-close-on-backdrop="true"
                     @ok.prevent="handleSubmit(addTicketPricing)" @show="resetModal" @hidden="resetModal">


                <ValidationProvider rules="required" name="Ticket Type" v-slot="{ valid, errors }">
                    <b-form-group
                        label="Ticket Type:"
                    >
                        <b-form-select
                            v-model="form.ticket_id"
                            :state="errors[0] ? false : (valid ? true : null)"
                        >
                            <template #first>
                                <b-form-select-option :value="null" disabled>-- Please select an option --
                                </b-form-select-option>
                            </template>
                            <b-form-select-option v-for="ticketType in tickettypes"
                                                  :key="ticketType.id"
                                                  :value="ticketType.id">
                                {{ticketType.name}}
                            </b-form-select-option>
                        </b-form-select>
                        <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                </ValidationProvider>

                <ValidationProvider rules="required|numeric" name="Price" v-slot="{ valid, errors }">
                    <b-form-group
                        label="Price:"
                    >
                        <b-form-input
                            type="number"
                            v-model="form.price"
                            :state="errors[0] ? false : (valid ? true : null)"
                            placeholder="Enter Price"
                        ></b-form-input>
                        <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                </ValidationProvider>

                <ValidationProvider rules="required|numeric" name="Reservations" v-slot="{ valid, errors }">
                    <b-form-group
                        label="Reservations:"
                    >
                        <b-form-input
                            type="number"
                            v-model="form.reservation_no"
                            :state="errors[0] ? false : (valid ? true : null)"
                            placeholder="Enter Reservations No"
                        ></b-form-input>
                        <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                </ValidationProvider>

                <template v-slot:modal-footer="{ ok, cancel}">
                    <b-button size="sm" variant="danger" @click="cancel()">
                        Cancel
                    </b-button>
                    <b-button size="sm" variant="primary" @click="ok()">
                        Add Pricing
                    </b-button>
                </template>
            </b-modal>
        </ValidationObserver>

        <!--        edit pricing modal-->
        <ValidationObserver ref="editTicketPricingObserver" v-slot="{ handleSubmit }">
            <b-modal ref="editTicketPricingModal" size="sm" centered title="Update Ticket Pricing"
                     :no-close-on-backdrop="true"
                     @ok.prevent="handleSubmit(updateTicketPricing)" @hidden="resetModal">


                <ValidationProvider rules="required" name="Ticket Type" v-slot="{ valid, errors }">
                    <b-form-group
                        label="Ticket Type:"
                    >
                        <b-form-select
                            v-model="form.ticket_id"
                            :state="errors[0] ? false : (valid ? true : null)"
                        >
                            <template #first>
                                <b-form-select-option :value="null" disabled>-- Please select an option --
                                </b-form-select-option>
                            </template>
                            <b-form-select-option v-for="ticketType in tickettypes"
                                                  :key="ticketType.id"
                                                  :value="ticketType.id">
                                {{ticketType.name}}
                            </b-form-select-option>
                        </b-form-select>
                        <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                </ValidationProvider>

                <ValidationProvider rules="required|numeric" name="Price" v-slot="{ valid, errors }">
                    <b-form-group
                        label="Price:"
                    >
                        <b-form-input
                            type="number"
                            v-model="form.price"
                            :state="errors[0] ? false : (valid ? true : null)"
                            placeholder="Enter Price"
                        ></b-form-input>
                        <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                </ValidationProvider>

                <ValidationProvider rules="required|numeric" name="Reservations" v-slot="{ valid, errors }">
                    <b-form-group
                        label="Reservations:"
                    >
                        <b-form-input
                            type="number"
                            v-model="form.reservation_no"
                            :state="errors[0] ? false : (valid ? true : null)"
                            placeholder="Enter Reservations No"
                        ></b-form-input>
                        <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                </ValidationProvider>

                <template v-slot:modal-footer="{ ok, cancel}">
                    <b-button size="sm" variant="danger" @click="cancel()">
                        Cancel
                    </b-button>
                    <b-button size="sm" variant="primary" @click="ok()">
                        Update Pricing
                    </b-button>
                </template>
            </b-modal>
        </ValidationObserver>

    </section>
</template>

<script>
    export default {
        name: "ViewEvent",
        props: ['event', 'tickettypes'],
        data() {
            return {
                isBusy: false,
                fields: [
                    {
                        label: '#',
                        key: 'Index'
                    },
                    {
                        key: 'user',
                        label: 'User'
                    },
                    {
                        key: 'type',
                        label: 'Type'
                    },
                    {
                        key: 'price',
                        label: 'Price'
                    },
                    {
                        key: 'code',
                        label: 'Code'
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
                tickets: [],
                form: {
                    ticket_id: null,
                    price: '',
                    reservation_no: ''
                },
                ticketPrices: [],
                isLoading: false
            }
        },
        computed: {
            date: function () {
                return this.moment(`${this.event.happening_date} ${this.event.happening_time}`).format('MMM Do YYYY h:mm:ss a');
            },
            fromNow: function () {
                return this.moment(`${this.event.happening_date} ${this.event.happening_time}`).fromNow();
            },
            rows() {
                return this.tickets.length;
            },
        },
        mounted() {
            this.getTicketPricing();
            this.getTickets();
        },
        methods: {
            getTickets() {
                this.isBusy = true;
                axios.get(`/admin/get-tickets/${this.event.id}`).then((response) => {
                    this.isBusy = false;
                    this.tickets = response.data;

                }).catch((error) => {
                    this.isBusy = false;
                })
            },
            getTicketPricing() {
                this.isLoading = true;
                axios.get(`/admin/ticket-prices/${this.event.id}`).then((response) => {
                    this.isLoading = false;
                    this.ticketPrices = response.data;

                }).catch((error) => {
                    this.isLoading = false;
                    console.log(error)
                })
            },
            showTicketPricingModal() {
                this.$refs['addTicketPricingModal'].show();
            },
            addTicketPricing() {

                axios.post(`/admin/store-ticket-price/${this.event.id}`, this.form).then((response) => {

                    this.ticketPrices.unshift(response.data);

                    this.$refs['addTicketPricingModal'].hide();

                    this.$notify({
                        title: 'Success',
                        message: 'Ticket price Added Successfully',
                        type: 'success'
                    });

                }).catch((error) => {
                    this.$notify({
                        title: 'Warning',
                        message: 'Something went wrong',
                        type: 'warning'
                    });
                    this.$refs.addTicketPricingObserver.setErrors(error.response.data.errors);
                })
            },
            showTicketPricingEditingModal(ticketPricing) {
                this.form = {...ticketPricing}
                this.$refs['editTicketPricingModal'].show();
            },
            updateTicketPricing() {
                axios.post(`/admin/update-ticket-price/${this.event.id}/${this.form.id}`, this.form).then((response) => {


                    let newTicketPricing = response.data;

                    this.ticketPrices = this.ticketPrices.map(ticketPrice => ticketPrice.id === newTicketPricing.id ? newTicketPricing : ticketPrice);

                    this.$refs['editTicketPricingModal'].hide();

                    this.$notify({
                        title: 'Success',
                        message: 'Ticket price Updated Successfully',
                        type: 'success'
                    });

                }).catch((error) => {
                    this.$notify({
                        title: 'Warning',
                        message: 'Something went wrong',
                        type: 'warning'
                    });
                    this.$refs.editTicketPricingObserver.setErrors(error.response.data.errors);
                })
            },
            deleteTicketPricing(ticketPricing) {
                this.$confirm(`${ticketPricing.ticket.name} ticket price will be permanently deleted. Continue?`, 'Warning', {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                }).then(() => {

                    axios.get(`/admin/delete-ticket-price/${ticketPricing.id}`)
                        .then((response) => {


                            let deletedId = response.data.id;

                            this.ticketPrices = this.ticketPrices.filter(ticketPrice => ticketPrice.id !== deletedId);

                            this.$notify({
                                title: 'Success',
                                message: 'Ticket Price Deleted Successfully',
                                type: 'success'
                            });

                        }).catch(() => {

                        this.$notify({
                            title: 'Warning',
                            message: 'Something went wrong',
                            type: 'warning'
                        })
                    })


                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
            },
            resetModal() {
                this.form = {
                    ticket_id: null,
                    price: '',
                    reservation_no: ''
                };
            },
            onFilteredTickets(filteredItems) {
                this.totalRows = filteredItems.length;
                this.currentPage = 1;
            },
        }
    }
</script>

<style scoped>

</style>
