<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h3 class="card-title">System Settings</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <b-tabs content-class="mt-3">
                                <b-tab title="General Settings" active>
                                    <ValidationObserver ref="addEventObserver" v-slot="{ handleSubmit }">
                                        <b-form @submit.prevent="handleSubmit(saveSetting)">
                                            <ValidationProvider rules="required" name="App Name"
                                                                v-slot="{ valid, errors }">
                                                <b-form-group
                                                    label="App Name:"
                                                >
                                                    <b-form-input
                                                        style="max-width: 500px"
                                                        type="text"
                                                        v-model="form.name"
                                                        :state="errors[0] ? false : (valid ? true : null)"
                                                        placeholder="Enter App Name"
                                                    ></b-form-input>
                                                    <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}
                                                    </b-form-invalid-feedback>
                                                </b-form-group>
                                            </ValidationProvider>
                                            <ValidationProvider rules="required" name="App Logo"
                                                                v-slot="{ valid, errors }">
                                                <b-form-group
                                                    label="App Logo:"
                                                >
                                                    <div class="mb-2">
                                                        <img
                                                            :src="form.logo"
                                                            class="img-thumbnail"
                                                            style="height: 100px; width: 100px" alt="">
                                                    </div>


                                                    <b-form-file
                                                        style="max-width: 500px"
                                                        v-model="form.file"
                                                        @change="showAvatar"
                                                        :state="errors[0] ? false : (valid ? true : null)"
                                                        placeholder="Select App Logo"
                                                    ></b-form-file>
                                                    <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}
                                                    </b-form-invalid-feedback>
                                                </b-form-group>
                                            </ValidationProvider>
                                            <ValidationProvider rules="required|numeric" name="Max Reservations"
                                                                v-slot="{ valid, errors }">
                                                <b-form-group
                                                    label="Max Reservations:"
                                                >
                                                    <b-form-input
                                                        style="max-width: 500px"
                                                        type="number"
                                                        v-model="form.maxReservations"
                                                        :state="errors[0] ? false : (valid ? true : null)"
                                                        placeholder="Enter Maximum reservations done by a customer"
                                                    ></b-form-input>
                                                    <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}
                                                    </b-form-invalid-feedback>
                                                </b-form-group>
                                            </ValidationProvider>
                                            <b-button type="submit" variant="primary" size="sm">Update</b-button>
                                        </b-form>
                                    </ValidationObserver>
                                    <hr>
                                    <p>Ticket Types</p>
                                    <div v-if="ticketTypes.length > 0" class="row my-3">
                                        <div v-for="(ticket,index) in ticketTypes" :key="ticket.id" class="col-md-2">
                                            <div class="p-2 my-2 badge badge-pill badge-primary">
                                                <span style="font-size: 15px">{{ticket.name}}</span>
                                                <span class="fas fa-edit p-2" style="cursor: pointer"
                                                      @click="showEditTicketModal(ticket)"></span>
                                                <span class="fas fa-trash p-2" style="cursor: pointer"
                                                      @click="deleteTicket(ticket)"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else class="row">
                                        <div class="col-md-12 text-center p-3">
                                            <h4>No Ticket Types Found </h4><span class="fas fa-surprise fa-2x"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ValidationObserver ref="addTicketTypeObserver" v-slot="{ handleSubmit }">
                                                <b-form @submit.prevent="handleSubmit(addTicketType)">
                                                    <div class="row" style="max-width: 500px">
                                                        <div class="col-md-8 col-sm-12">
                                                            <ValidationProvider rules="required" name="name"
                                                                                v-slot="{ valid, errors }">
                                                                <b-form-input
                                                                    type="text"
                                                                    v-model="ticketType"
                                                                    :state="errors[0] ? false : (valid ? true : null)"
                                                                    placeholder="Enter Ticket Type"
                                                                ></b-form-input>
                                                                <b-form-invalid-feedback id="inputLiveFeedback">{{
                                                                    errors[0] }}
                                                                </b-form-invalid-feedback>
                                                            </ValidationProvider>
                                                        </div>
                                                        <div class="col-md-4 col-sm-12">
                                                            <b-button type="submit" class="mt-2" variant="primary"
                                                                      size="sm">
                                                                <b-icon icon="plus"></b-icon>
                                                                Add New
                                                            </b-button>
                                                        </div>
                                                    </div>
                                                </b-form>
                                            </ValidationObserver>
                                        </div>
                                    </div>
                                </b-tab>
                                <b-tab title="Locations">
                                    <div v-if="locations.length > 0" class="row my-3">
                                        <div v-for="(location,index) in locations" :key="location.id" class="col-md-2">
                                            <div class="p-2 my-2 badge badge-pill badge-primary">
                                                <span style="font-size: 15px">{{location.name}}</span>
                                                <span class="fas fa-edit p-2" style="cursor: pointer"
                                                      @click="showEditLocationModal(location)"></span>
                                                <span class="fas fa-trash p-2" style="cursor: pointer"
                                                      @click="deleteLocation(location)"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else class="row">
                                        <div class="col-md-12 text-center p-3">
                                            <h4>No locations Found </h4><span class="fas fa-surprise fa-2x"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ValidationObserver ref="addLocationObserver" v-slot="{ handleSubmit }">
                                                <b-form @submit.prevent="handleSubmit(addLocation)">
                                                    <div class="row" style="max-width: 500px">
                                                        <div class="col-md-8 col-sm-12">
                                                            <ValidationProvider rules="required" name="name"
                                                                                v-slot="{ valid, errors }">
                                                                <b-form-input
                                                                    type="text"
                                                                    v-model="location"
                                                                    :state="errors[0] ? false : (valid ? true : null)"
                                                                    placeholder="Enter Location name"
                                                                ></b-form-input>
                                                                <b-form-invalid-feedback id="inputLiveFeedback">{{
                                                                    errors[0] }}
                                                                </b-form-invalid-feedback>
                                                            </ValidationProvider>
                                                        </div>
                                                        <div class="col-md-4 col-sm-12">
                                                            <b-button type="submit" class="mt-2" variant="primary"
                                                                      size="sm">
                                                                <b-icon icon="plus"></b-icon>
                                                                Add New
                                                            </b-button>
                                                        </div>
                                                    </div>
                                                </b-form>
                                            </ValidationObserver>
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
        <!-- /.container-fluid -->

        <!--        edit ticket type-->
        <ValidationObserver ref="editTicketTypeObserver" v-slot="{ handleSubmit }">
            <b-modal ref="editTicketModal" size="sm" centered title="Update Ticket" :no-close-on-backdrop="true"
                     @ok.prevent="handleSubmit(updateTicket)" @hidden="resetModal">
                <ValidationProvider rules="required" name="Email" v-slot="{ valid, errors }">
                    <b-form-group
                        label="Name:"
                    >
                        <b-form-input
                            type="email"
                            v-model="selectedTicket.name"
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
                        Update
                    </b-button>
                </template>
            </b-modal>
        </ValidationObserver>

        <!--        edit location-->
        <ValidationObserver ref="editLocationObserver" v-slot="{ handleSubmit }">
            <b-modal ref="editLocationModal" size="sm" centered title="Update Ticket" :no-close-on-backdrop="true"
                     @ok.prevent="handleSubmit(updateLocation)" @hidden="resetEditLocationModal">
                <ValidationProvider rules="required" name="Email" v-slot="{ valid, errors }">
                    <b-form-group
                        label="Name:"
                    >
                        <b-form-input
                            type="email"
                            v-model="selectedLocation.name"
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
                        Update
                    </b-button>
                </template>
            </b-modal>
        </ValidationObserver>

    </section>
</template>

<script>
    export default {
        name: "Settings",
        data() {
            return {
                form: {
                    name: '',
                    logo: null,
                    file: null,
                    maxReservations: ''
                },
                ticketType: '',
                selectedTicket: {
                    id: '',
                    name: ''
                },
                ticketTypes: [],
                location: '',
                selectedLocation: {
                    id: '',
                    name: ''
                },
                locations: []
            }
        },
        created() {
            this.getTicketTypes();
            this.getLocations();
        },
        methods: {
            getLocations() {
                axios.get("/admin/get-locations").then((response) => {

                    this.locations = response.data;

                }).catch((error) => {
                    console.log(error);
                })
            },
            getTicketTypes() {
                axios.get("/admin/get-ticket-types").then((response) => {

                    this.ticketTypes = response.data;

                }).catch((error) => {
                    console.log(error);
                })
            },
            showEditLocationModal(location) {
                this.$refs['editLocationModal'].show();
                this.selectedLocation = {
                    ...location
                };
            },
            deleteLocation(location) {
                this.$confirm(`${location.name} location will be permanently deleted. Continue?`, 'Warning', {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                }).then(() => {

                    axios.get(`/admin/delete-location/${location.id}`)
                        .then((response) => {


                            let deletedId = response.data.id;

                            this.locations = this.locations.filter(location => location.id !== deletedId);

                            this.$notify({
                                title: 'Success',
                                message: 'Location Deleted Successfully',
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
            updateLocation() {
                let request = {
                    name: this.selectedLocation.name,
                };

                axios.post(`/admin/update-location/${this.selectedLocation.id}`, request).then((response) => {

                    let newLocation = response.data;

                    this.locations = this.locations.map(location => location.id === newLocation.id ? newLocation : location);

                    this.$refs['editLocationModal'].hide();

                    this.$notify({
                        title: 'Success',
                        message: 'Location Updated Successfully',
                        type: 'success'
                    });

                }).catch((error) => {
                    this.$notify({
                        title: 'Warning',
                        message: 'Something went wrong',
                        type: 'warning'
                    });
                    this.$refs.editLocationObserver.setErrors(error.response.data.errors);
                })
            },
            addLocation() {
                let request = {
                    name: this.location,
                };

                axios.post("/admin/add-location", request).then((response) => {

                    this.locations.unshift(response.data);

                    this.location = '';

                    this.$notify({
                        title: 'Success',
                        message: 'Location Added Successfully',
                        type: 'success'
                    });

                }).catch((error) => {
                    this.$notify({
                        title: 'Warning',
                        message: 'Something went wrong',
                        type: 'warning'
                    });
                    this.$refs.addLocationObserver.setErrors(error.response.data.errors);
                })
            },
            showEditTicketModal(ticket) {
                this.$refs['editTicketModal'].show();
                this.selectedTicket = {
                    ...ticket
                };
            },
            updateTicket() {
                let request = {
                    name: this.selectedTicket.name,
                };

                axios.post(`/admin/update-ticket-type/${this.selectedTicket.id}`, request).then((response) => {

                    let newTicketType = response.data;

                    this.ticketTypes = this.ticketTypes.map(ticketType => ticketType.id === newTicketType.id ? newTicketType : ticketType);

                    this.$refs['editTicketModal'].hide();

                    this.$notify({
                        title: 'Success',
                        message: 'Ticket Updated Successfully',
                        type: 'success'
                    });

                }).catch((error) => {
                    this.$notify({
                        title: 'Warning',
                        message: 'Something went wrong',
                        type: 'warning'
                    });
                    this.$refs.editTicketTypeObserver.setErrors(error.response.data.errors);
                })
            },
            deleteTicket(ticket) {
                this.$confirm(`${ticket.name} ticket will be permanently deleted. Continue?`, 'Warning', {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                }).then(() => {

                    axios.get(`/admin/delete-ticket-type/${ticket.id}`)
                        .then((response) => {


                            let deletedId = response.data.id;

                            this.ticketTypes = this.ticketTypes.filter(ticketType => ticketType.id !== deletedId);

                            this.$notify({
                                title: 'Success',
                                message: 'Ticket Type Deleted Successfully',
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
            showAvatar(e) {
                let file = e.target.files[0];
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.form.logo = event.target.result;
                }
                reader.readAsDataURL(file);
            },
            saveSetting() {

                let request = {
                    name: this.form.name,
                    logo: this.form.logo,
                    maxReservations: this.form.maxReservations,
                };

                axios.post("/admin/update-settings", request).then((response) => {

                    console.log(response.data);

                }).catch((error) => {
                    console.log(error);
                })
            },
            addTicketType() {
                let request = {
                    name: this.ticketType,
                };

                axios.post("/admin/add-ticket-type", request).then((response) => {

                    this.ticketTypes.unshift(response.data);

                    this.ticketType = '';

                    this.$notify({
                        title: 'Success',
                        message: 'Ticket Added Successfully',
                        type: 'success'
                    });

                }).catch((error) => {
                    this.$notify({
                        title: 'Warning',
                        message: 'Something went wrong',
                        type: 'warning'
                    });
                    this.$refs.addTicketTypeObserver.setErrors(error.response.data.errors);
                })
            },
            resetModal() {
                this.selectedTicket = {
                    id: '',
                    name: '',
                };
            },
            resetEditLocationModal() {
                this.selectedLocation = {
                    id: '',
                    name: ''
                }
            }
        }
    }
</script>

<style scoped>

</style>
