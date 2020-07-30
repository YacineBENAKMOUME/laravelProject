<template>
    <div class="container">
        <div class="row justify-content-center" v-if="$gate.isRsf()">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Hotellerie Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8" v-if="!$gate.isRsf()">
               <not-found></not-found> 
            <!--  <router-link to="/formation" class="nav-link" style="pointer-events: none;cursor: default;opacity: 0.6;"> -->
        </div>



    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>s