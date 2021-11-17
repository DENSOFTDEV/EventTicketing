<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h3 class="card-title">Update Events Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ValidationObserver ref="updateEventObserver" v-slot="{ handleSubmit }">
                                <b-form @submit.prevent="handleSubmit(updateEvent)">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ValidationProvider rules="required" name="Name"
                                                                v-slot="{ valid, errors }">
                                                <b-form-group
                                                    label="Name:"
                                                >
                                                    <b-form-input
                                                        type="text"
                                                        v-model="form.name"
                                                        :state="errors[0] ? false : (valid ? true : null)"
                                                        placeholder="Enter Name"
                                                    ></b-form-input>
                                                    <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}
                                                    </b-form-invalid-feedback>
                                                </b-form-group>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-md-6">
                                            <ValidationProvider rules="required" name="Hashtag"
                                                                v-slot="{ valid, errors }">
                                                <b-form-group
                                                    label="Hashtag:"
                                                >
                                                    <b-form-input
                                                        type="text"
                                                        v-model="form.hashTag"
                                                        :state="errors[0] ? false : (valid ? true : null)"
                                                        placeholder="Enter Hashtag"
                                                    ></b-form-input>
                                                    <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}
                                                    </b-form-invalid-feedback>
                                                </b-form-group>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-md-6">
                                            <ValidationProvider rules="required" name="Location"
                                                                v-slot="{ valid, errors }">
                                                <b-form-group label="Location:">
                                                    <b-form-select
                                                        v-model="form.location"
                                                        :state="errors[0] ? false : (valid ? true : null)"
                                                    >
                                                        <b-form-select-option v-for="location in locations"
                                                                              :key="location.id"
                                                                              :value="location.id">
                                                            {{location.name}}
                                                        </b-form-select-option>
                                                    </b-form-select>
                                                    <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}
                                                    </b-form-invalid-feedback>
                                                </b-form-group>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-md-6">
                                            <ValidationProvider rules="required" name="Venue"
                                                                v-slot="{ valid, errors }">
                                                <b-form-group label="Venue:">
                                                    <b-form-input
                                                        type="text"
                                                        @input="disSuggestions"
                                                        v-model="form.venue"
                                                        :state="errors[0] ? false : (valid ? true : null)"
                                                        placeholder="Enter Venue"
                                                    ></b-form-input>
                                                    <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}
                                                    </b-form-invalid-feedback>
                                                    <ul style="list-style: none" v-if="showSuggestions">
                                                        <li v-for="(result, i) in searchResults" :key="i">
                                                            <a href="#" @click="addLoc(result)" class="text-primary">{{
                                                                result
                                                                }}</a>
                                                        </li>
                                                    </ul>
                                                </b-form-group>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-md-6">
                                            <ValidationProvider rules="required" name="Poster"
                                                                v-slot="{ valid, errors }">
                                                <b-form-group
                                                    label="Poster:"
                                                >
                                                    <div class="row">
                                                        <div v-if="form.poster_url" class="col-md-4">
                                                            <img
                                                                :src="form.poster_url"
                                                                class="img-thumbnail"
                                                                style="height: 100px; width: 100px" alt="">
                                                        </div>
                                                        <div class="col-md-8">
                                                            <b-form-file
                                                                style="max-width: 500px"
                                                                v-model="form.file"
                                                                @change="showPoster"
                                                                :state="errors[0] ? false : (valid ? true : null)"
                                                                placeholder="Select Poster"
                                                            ></b-form-file>
                                                            <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0]
                                                                }}
                                                            </b-form-invalid-feedback>
                                                        </div>
                                                    </div>
                                                </b-form-group>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-md-6">
                                            <ValidationProvider rules="required" name="Happening Date"
                                                                v-slot="{ valid, errors }">
                                                <b-form-group
                                                    label="Happening Date:"
                                                >
                                                    <b-form-datepicker
                                                        id="example-datepicker"
                                                        v-model="form.happening_date"
                                                        :state="errors[0] ? false : (valid ? true : null)"
                                                        :min="min"
                                                        :max="max"
                                                        today-button
                                                        reset-button
                                                        close-button
                                                        locale="en"
                                                    >

                                                    </b-form-datepicker>

                                                    <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}
                                                    </b-form-invalid-feedback>
                                                </b-form-group>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-md-6">
                                            <ValidationProvider rules="required" name="Happening Time"
                                                                v-slot="{ valid, errors }">
                                                <b-form-group
                                                    label="Happening Time:"
                                                >
                                                    <b-form-timepicker
                                                        v-model="form.happening_time"
                                                        :state="errors[0] ? false : (valid ? true : null)"
                                                        locale="en"
                                                    >

                                                    </b-form-timepicker>

                                                    <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}
                                                    </b-form-invalid-feedback>
                                                </b-form-group>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-md-6">
                                            <ValidationProvider rules="required" name="Duration"
                                                                v-slot="{ valid, errors }">
                                                <b-form-group
                                                    label="Duration:"
                                                >
                                                    <b-form-input
                                                        type="number"
                                                        v-model="form.duration"
                                                        :state="errors[0] ? false : (valid ? true : null)"
                                                        placeholder="Enter Duration"
                                                    ></b-form-input>
                                                    <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}
                                                    </b-form-invalid-feedback>
                                                </b-form-group>
                                            </ValidationProvider>
                                        </div>
                                    </div>
                                    <b-button type="submit" variant="primary" size="sm" :disabled="isLoading">
                                        <b-spinner v-if="isLoading" small type="grow"></b-spinner>
                                        {{isLoading ? 'Please wait...' : 'Update Event'}}
                                    </b-button>
                                </b-form>
                            </ValidationObserver>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>

    </section>
</template>

<script>
    export default {
        name: "EditEvent",
        props: ['locations', 'event'],
        data() {
            const now = new Date()
            const today = new Date(now.getFullYear(), now.getMonth(), now.getDate())
            const minDate = new Date(today)
            minDate.setDate(minDate.getDate() + 2)
            const maxDate = new Date(today)
            maxDate.setDate(maxDate.getDate() + 45)
            return {
                form: {...this.event, file: null},
                min: minDate,
                max: maxDate,
                searchResults: [],
                showSuggestions: false,
                isLoading: false
            }
        },
        computed: {
            location() {
                return this.form.venue
            },
        },
        watch: {
            location(newValue) {
                if (newValue) {
                    this.service.getPlacePredictions({
                        input: this.form.venue,
                        types: ['geocode'],
                        componentRestrictions: {country: 'ke'}
                    }, this.displaySuggestions)
                }
            },
        },
        mounted() {
            this.service = new window.google.maps.places.AutocompleteService();
        },
        methods: {
            updateEvent() {
                this.isLoading = true;
                axios.post(`/admin/update-event/${this.form.id}`, this.form).then((response) => {

                    this.isLoading = false;

                    this.$notify({
                        title: 'Success',
                        message: 'Event Updated Successfully',
                        type: 'success'
                    });

                    window.location.href = '/admin/events';

                }).catch((error) => {
                    this.isLoading = false;
                    this.$notify({
                        title: 'Warning',
                        message: 'Something went wrong',
                        type: 'warning'
                    });
                    this.$refs.updateEventObserver.setErrors(error.response.data.errors);
                })

            },
            showPoster(e) {
                let file = e.target.files[0];
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.form.poster_url = event.target.result;
                }
                reader.readAsDataURL(file);
            },
            addLoc(result) {
                this.form.venue = result;
                this.showSuggestions = false;
            },
            disSuggestions() {
                this.showSuggestions = true;
            },
            displaySuggestions(predictions, status) {
                if (status !== window.google.maps.places.PlacesServiceStatus.OK) {
                    this.searchResults = [];
                    return
                }
                this.searchResults = predictions.map(prediction => prediction.description);
            },
        }
    }
</script>

<style scoped>

</style>
