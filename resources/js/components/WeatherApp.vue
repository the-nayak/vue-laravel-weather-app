<template>
    <div class="container mx-auto">
        <div class="shadow-lg w-11/12 mx-auto md:w-6/12">
            <div class=" bg-gray-800 rounded-t-lg mt-20">
                <h1 class="text-center pt-5 font-bold text-4xl text-gray-400">Weather App</h1>
                <div class="w-11/12 mx-auto py-5">
                    <input type="search" id="address" class="form-control form-control bg-white focus:outline-none focus:shadow-lg focus:border-w-2 focus:border-teal-500 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" placeholder="Where are we going?" />
                    <p class="text-gray-500 mt-3">Selected: <strong id="address-value">none</strong></p>
                </div> 
            </div>
            <div class=" bg-gray-900 py-6 rounded-b-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-start mx-6 w-1/4">
                        <div class="text-5xl text-gray-500 font-bold sm:text-6xl">{{currentTemperature.actual}}<sup>o</sup>C</div>
                        <div class="text-base text-gray-500 font-medium mx-4">{{location.city}} <br><span class="text-sm">{{location.country}}</span></div>
                    </div>
                    <div class="w-1/4 text-gray-500">{{currentTemperature.summary}}</div>
                </div>
                <p class="text-gray-500 text-sm mx-6">Feels like {{currentTemperature.feels}}<sup>o</sup>C</p>
            </div>
            <!-- <div class="bg-gray-800 py-6 text-gray-400 flex justify-between px-6 items-center rounded-b-lg">
                <div class="w-1/12">
                    <p class="text-2xl font-bold">Tue</p>
                </div>
                <div class="w-9/12 flex justify-start items-center">
                    <p class="mx-3 inline-block">icon</p>
                    <p class="text-base">light rain in the morning and afternoon.</p>
                </div>
                <div class="w-1/12">
                    <p>5<sup>o</sup>C</p>
                    <p>5<sup>o</sup>C</p>
                </div>
            </div> -->
</div>
    </div>
</template>

<script>
    export default {
        mounted() {
            
            this.fetchData()
            var placesAutocomplete = places({
                appId: 'pl8P9HXEV66M',
                apiKey: '4bc2d7cb8e625b6f31e2673c457c04cd',
                container: document.querySelector('#address')
            }).configure({
                    type: 'city',
                    aroundLatLngViaIP: false,
                });

            var $address = document.querySelector('#address-value')
            placesAutocomplete.on('change',(e) => {
                $address.textContent = e.suggestion.value   
                this.location.city = `${e.suggestion.name}`
                this.location.country = `${e.suggestion.countryCode}`.toUpperCase()

            });

            placesAutocomplete.on('clear', function() {
                $address.textContent = 'none';
            });
               
        },
         watch:{
            location:{
                handler(newValue, oldValue){                   
                    this.fetchData()
                },
                deep: true
            }
        },
        data() {
            return {
                location: {
                    city : 'Indore',
                    country : 'IN'
                },
                currentTemperature: {
                    actual : '',
                    feels : '',
                    summary : '',
                    icon : ''
                }
            }
        },
       
        methods:{
            fetchData(){
               fetch(`/api/weather?city_name=${ this.location.city }&country_code=${ this.location.country }`)
                    .then(response => response.json())
                    .then(data => {
                        this.currentTemperature.actual = Math.round(data.data[0].temp)
                        this.currentTemperature.feels = Math.round(data.data[0].app_temp)
                        this.currentTemperature.summary = data.data[0].weather.description
                    })
            }
        }
    }
</script>
