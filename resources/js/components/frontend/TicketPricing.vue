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
    </div>
</template>

<script>
    export default {
        name: "TicketPricing",
        props: ['event'],
    }
</script>

<style scoped>

</style>
