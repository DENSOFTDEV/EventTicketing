<template>
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div v-if="events.length > 0" class="row">
                <div v-for="event in events" :key="event.id" class="col-md-3 mb-5">
                    <div class="card h-100">
                        <!-- Sale badge-->
                        <div class="badge bg-success text-white position-absolute" style="top: 0.5rem; right: 0.5rem">
                            <h4>{{moment(`${event.happening_date} ${event.happening_time}`).fromNow()}}</h4>
                        </div>
                        <!-- Product image-->
                        <img class="card-img-top" :src="event.poster_url" alt="..."/>
                        <!-- Product details-->
                        <div class="card-body p-2">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder">{{event.name}}</h5>

                                <!-- Product price-->
                                <ul style="list-style: none">
                                    <li v-for="price in event.ticket_prices" :key="price.id">
                                        <span>{{price.ticket.name}}</span> <span>{{price.price}}</span>
                                    </li>
                                </ul>
                                <p>location: {{event.location.name}}</p>
                                <p>venue: {{event.venue}}</p>
                                <h5><i class="fas fa-stopwatch mr-2 text-success"></i>{{event.duration}} hrs</h5>
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto"
                                                        :href="`/event/${event.id}`">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="text-center mb-5">
                <h3>No Events found <span class="far fa-sad-tear fa-3x text-success"></span></h3>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "events",
        data() {
            return {
                events: []
            }
        },
        mounted() {
            this.getEvents();
        },
        methods: {
            getEvents() {
                axios.get('/events').then((response) => {
                    this.events = response.data;
                }).catch((error) => {
                    console.log(error)
                })
            }
        }
    }
</script>

<style scoped>

</style>
