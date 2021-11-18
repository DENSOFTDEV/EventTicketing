<template>
    <div class="my-3">
        <div class="text-center" style="margin-bottom: 20px">
            <h4>Ticket Pricing</h4>
        </div>
        <div class="row" style="margin-bottom: 20px">
            <div v-for="pricing in event.ticket_prices" :key="pricing.id" class="col-lg-6 col-xl-4">
                <div class="card mb-5 mb-xl-0 bg-white">
                    <div class="card-body p-5">
                        <div class="small text-uppercase fw-bold text-success">{{pricing.ticket.name}}</div>
                        <div class="mb-3">
                            <span class="display-4 fw-bold">{{pricing.price}}</span>
                            <span class="text-muted">/ ksh.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center" style="margin-bottom: 20px">
            <h4>Ticket Reservation</h4>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">

                        <div v-if="message" class="alert alert-success alert-dismissible fade show" role="alert">
                            {{message}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>


                        <div v-if="error" class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{error}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <ValidationObserver ref="reserveTicketObserver" v-slot="{ handleSubmit }">
                            <b-form @submit.prevent="handleSubmit(reserveTicket)">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ValidationProvider rules="required" name="Ticket Type"
                                                            v-slot="{ valid, errors }">
                                            <b-form-group label="Ticket Type:">
                                                <b-form-select
                                                    v-model="form.ticket_id"
                                                    :state="errors[0] ? false : (valid ? true : null)"
                                                >
                                                    <template #first>
                                                        <b-form-select-option :value="null" disabled>-- Please select
                                                            ticket
                                                            type --
                                                        </b-form-select-option>
                                                    </template>
                                                    <b-form-select-option v-for="pricing in event.ticket_prices"
                                                                          :key="pricing.id"
                                                                          :value="pricing.id">
                                                        {{pricing.ticket.name}}
                                                    </b-form-select-option>
                                                </b-form-select>
                                                <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </ValidationProvider>
                                    </div>

                                    <div class="col-md-4">
                                        <ValidationProvider rules="required" name="Reservations No"
                                                            v-slot="{ valid, errors }">
                                            <b-form-group label="Reservations No:">
                                                <b-form-select
                                                    v-model="form.reservation_no"
                                                    :state="errors[0] ? false : (valid ? true : null)"
                                                >
                                                    <template #first>
                                                        <b-form-select-option :value="null" disabled>-- Please select
                                                            reservations no --
                                                        </b-form-select-option>
                                                    </template>
                                                    <b-form-select-option v-for="no in 5"
                                                                          :key="no"
                                                                          :value="no">
                                                        {{no}}
                                                    </b-form-select-option>
                                                </b-form-select>
                                                <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </ValidationProvider>
                                    </div>
                                </div>
                                <b-button type="submit" variant="primary" size="sm" :disabled="isLoading">
                                    <b-spinner v-if="isLoading" small type="grow"></b-spinner>
                                    {{isLoading ? 'Please wait...' : 'Place Reservation'}}
                                </b-button>
                            </b-form>
                        </ValidationObserver>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "TicketReservation",
        props: ['event'],
        data() {
            return {
                form: {
                    ticket_id: null,
                    reservation_no: null
                },
                isLoading: false,
                error: null,
                message: null
            }


        },
        mounted() {
        },
        methods: {
            reserveTicket() {
                this.isLoading = true;
                this.clearData();
                axios.post(`/reserve-ticket/${this.event.id}`, this.form).then((response) => {
                    this.message = response.data.message;
                    this.isLoading = false;

                }).catch((error) => {
                    this.error = error.response.data.error;
                    this.isLoading = false;
                })
            },
            clearData() {
                this.error = null;
                this.message = null;

            }
        }
    }
</script>

<style scoped>

</style>
