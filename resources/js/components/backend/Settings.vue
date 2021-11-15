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
                                                        style="width: 500px"
                                                        type="email"
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
                                                    <b-form-file
                                                        style="width: 500px"
                                                        type="email"
                                                        v-model="form.logo"
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
                                                        style="width: 500px"
                                                        type="number"
                                                        v-model="form.maxReservations"
                                                        :state="errors[0] ? false : (valid ? true : null)"
                                                        placeholder="Enter Maximum reservations done by a customer"
                                                    ></b-form-input>
                                                    <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}
                                                    </b-form-invalid-feedback>
                                                </b-form-group>
                                            </ValidationProvider>
                                            <b-button variant="primary" size="sm">Update</b-button>
                                        </b-form>
                                    </ValidationObserver>
                                    <hr>
                                    <p>Ticket Types</p>
                                    <b-button variant="primary" size="sm">
                                        <b-icon icon="plus"></b-icon>
                                        Add New
                                    </b-button>
                                </b-tab>
                                <b-tab title="Locations">
                                    <b-button variant="primary" size="sm">
                                        <b-icon icon="plus"></b-icon>
                                        Add New
                                    </b-button>
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
    </section>
</template>

<script>
    export default {
        name: "Settings",
        data() {
            return {
                form: {
                    name: '',
                    logo: '',
                    maxReservations: ''
                }
            }
        },
        methods: {
            saveSetting() {

            }
        }
    }
</script>

<style scoped>

</style>
