<template>
  <div>
    <slider-component></slider-component>
    <!--        <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 text-danger">-->
    <!--            <div-->
    <!--                class="h-7 w-1/2 mx-auto  m-3 p-1 bg-white shadow-md rounded-lg transition duration-700 hover:shadow-xl cursor-pointer animate__animated animate__fadeIn"-->
    <!--                v-if="goBack === false"-->
    <!--                @click="filterServices('Ended')">-->
    <!--                <p class="text-center font-weight-bold"><i class="fas fa-history"></i> Ended</p>-->
    <!--            </div>-->
    <!--            <div-->
    <!--                class="h-7 w-1/2 mx-auto  m-3 p-1 bg-white shadow-md rounded-lg transition duration-700 hover:shadow-xl cursor-pointer animate__animated animate__fadeIn"-->
    <!--                v-if="goBack === true"-->
    <!--                @click="filterServices(null)">-->
    <!--                <p class="text-center font-weight-bold"><i class="fas fa-angle-double-left"></i> Go Back</p>-->
    <!--            </div>-->
    <!--        </div>-->
    <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 text-lg text-theme-color">
      <div
          class="h-9 m-3 p-1 bg-white shadow-md rounded-lg transition duration-700 hover:shadow-xl cursor-pointer animate__animated animate__fadeIn"
          :class="[(active === true ? 'shadow-xl active-service' : '')]"
          @click="filterServices('Active')">
        <p class="text-center font-weight-bold"><i class="far fa-check-circle"></i> Active</p>
      </div>
      <div
          class="h-9  m-3 p-1 bg-white shadow-md rounded-lg transition duration-700 hover:shadow-xl cursor-pointer animate__animated animate__fadeIn "
          :class="[(active === false ? 'shadow-xl active-service' : '')]"
          @click="filterServices('Ended')">
        <p class="text-center font-weight-bold"><i class="far fa-arrow-alt-circle-right"></i> Ended</p>
      </div>
    </div>
    <div v-show="services.count === 0"
         class="animate__animated animate__fadeIn m-3 p-1 bg-white shadow-md rounded-lg transition duration-300 hover:shadow-xl relative overflow-hidden service-box pt-3">
      <p class="w-full text-2xl text-center my-10">Not found services.</p>
    </div>
    <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1">

      <a :href="'services/' + service.id" v-for="service in services"
         class="animate__animated animate__fadeIn">
        <div
            class="h-44 m-3 p-1 bg-white shadow-md rounded-lg transition duration-300 hover:shadow-xl relative overflow-hidden service-box pt-3">
          <div class="h-8 w-40  transform -right-12 top-5 rotate-45 z-1 absolute"
               :class="[(service.rating === 'not_rated' ? 'bg-gray-500' : 'bg-yellow-500'), (service.rating === 'promising' ? 'bg-yellow-500' : ''), (service.rating === 'high' ? 'bg-green-500' : '')] "
          >
            <p class="text-white  mt-2 text-center">{{ service.ratingTranslated }}</p>
          </div>

          <div class="">
            <div class="h-24 service-logo pl-2 mx-auto float-left">
              <img class="h-24 w-24 my-3 rounded-full"
                   :src="'/storage/'+service.logo">
            </div>
            <div class="float-left service-content text-left">
              <h2 class="text-theme-color text-left ml-3 my-3 text-2xl title font-weight-bold">
                {{ service.title }}</h2>

              <!--                        <h3 class="text-2xl mx-auto text-center"><span class="font-weight-bold">Rating:</span> <span  :class="[(service.rating === 'not_rated' ? 'text-gray-500' : 'text-yellow-500'), (service.rating === 'promising' ? 'text-yellow-500' : ''), (service.rating === 'high' ? 'text-green-500' : '')] ">{{service.ratingTranslated}}</span></h3>-->
              <div class="text-left w-full text-xl uppercase font-weight-bolder flex ml-3"
                   v-if="service.requirements">
                <div class="w-1/2 text-sm text-left">
                  <p class="text-left"><i class="fas fa-microchip mr-2"></i><small>CPU:</small>
                    {{ service.requirements.cpu }}</p>
                  <p class="text-left mt-1"><i class="fas fa-memory mr-2"></i><small>RAM:</small>
                    {{ service.requirements.ram }}</p>
                </div>
                <div class="w-1/2 text-sm text-left">
                  <p class="text-left"><i class="fas fa-database mr-2"></i><small>STORAGE:</small>
                    {{ service.requirements.storage }}</p>
                  <p class="text-left mt-1"><i class="fas fa-network-wired mr-2"></i><small>NETWORK:</small>
                    {{ service.requirements.network }}</p>
                </div>
              </div>
              <div class="ml-3" v-else>No System Requirements</div>
              <div
                  class="grid lg:grid-cols-1 p-1 text-2xl absolute bottom-0 text-center -left-96 text-white bg-danger w-1/2 service-box-left-belt">
                <div class="inline-block mr-2">
                  <!--<i class="fas fa-wrench inline-block" v-for="(n, i) in parseInt(service.complexity)"></i>-->
                  <a :href="service.guide.twitter" target="_blank"
                     v-if="service.guide && service.guide.twitter !== null"><i
                      class="fab fa-twitter inline-block transition duration-300 hover:text-theme-color"></i></a>
                  <a :href="service.guide.telegram" target="_blank"
                     v-if="service.guide && service.guide.telegram !== null"><i
                      class="fab fa-telegram-plane inline-block transition duration-300 hover:text-theme-color"></i></a>
                  <a :href="service.guide.website" target="_blank"
                     v-if="service.guide && service.guide.website !== null"><i
                      class="fas fa-globe inline-block transition duration-300 hover:text-theme-color"></i></a>
                  <a :href="service.guide.facebook" target="_blank"
                     v-if="service.guide && service.guide.facebook !== null"><i
                      class="fab fa-facebook inline-block transition duration-300 hover:text-theme-color"></i></a>

                </div>
              </div>

              <div
                  class="grid lg:grid-cols-1 p-1 text-2xl absolute bottom-0 text-center -right-96 bg-theme-color text-white w-1/2 service-box-right-belt">
                <div class="inline"><p class="inline w-auto px-1 text-lg"
                                       v-for="type in service.types">
                  {{ type.title }} </p></div>
              </div>
            </div>

          </div>


        </div>
      </a>

      <!--            <div class="">-->
      <!--                <a :href="'services/' + service.id" v-for="service in services" v-if="service.status === 'Upcoming'"-->
      <!--                   class="animate__animated animate__fadeIn">-->
      <!--                    <div-->
      <!--                        class="h-44 m-3 p-1 bg-white shadow-md rounded-lg transition duration-300 hover:shadow-xl relative overflow-hidden service-box pt-3">-->
      <!--                        <div class="h-8 w-40  transform -right-12 top-5 rotate-45 z-1 absolute"-->
      <!--                             :class="[(service.rating === 'not_rated' ? 'bg-gray-500' : 'bg-yellow-500'), (service.rating === 'promising' ? 'bg-yellow-500' : ''), (service.rating === 'high' ? 'bg-green-500' : '')] "-->
      <!--                        >-->
      <!--                            <p class="text-white  mt-2 text-center">{{ service.ratingTranslated }}</p>-->
      <!--                        </div>-->

      <!--                        <div class="">-->
      <!--                            <div class="h-24 service-logo pl-2 mx-auto float-left">-->
      <!--                                <img class="h-24 w-24 my-3 rounded-full"-->
      <!--                                     :src="'/'+service.logo">-->
      <!--                            </div>-->
      <!--                            <div class="float-left service-content text-left">-->
      <!--                                <h2 class="text-theme-color text-left ml-3 my-3 text-2xl title font-weight-bold">-->
      <!--                                    {{ service.title }}</h2>-->

      <!--                                &lt;!&ndash;                        <h3 class="text-2xl mx-auto text-center"><span class="font-weight-bold">Rating:</span> <span  :class="[(service.rating === 'not_rated' ? 'text-gray-500' : 'text-yellow-500'), (service.rating === 'promising' ? 'text-yellow-500' : ''), (service.rating === 'high' ? 'text-green-500' : '')] ">{{service.ratingTranslated}}</span></h3>&ndash;&gt;-->

      <!--                                <div class="text-left w-full text-xl uppercase font-weight-bolder flex ml-3"-->
      <!--                                     v-if="service.requirements">-->
      <!--                                    <div class="w-1/2 text-sm text-left">-->
      <!--                                        <p class="text-left"><i class="fas fa-microchip mr-2"></i><small>CPU:</small>-->
      <!--                                            {{ service.requirements.cpu }}</p>-->
      <!--                                        <p class="text-left"><i class="fas fa-memory mr-2"></i><small>RAM:</small>-->
      <!--                                            {{ service.requirements.ram }}</p>-->
      <!--                                    </div>-->
      <!--                                    <div class="w-1/2 text-sm text-left">-->
      <!--                                        <p class="text-left"><i class="fas fa-database mr-2"></i><small>STORAGE:</small>-->
      <!--                                            {{ service.requirements.storage }}</p>-->
      <!--                                        <p class="text-left"><i-->
      <!--                                            class="fas fa-network-wired mr-2"></i><small>NETWORK:</small>-->
      <!--                                            {{ service.requirements.network }}</p>-->
      <!--                                    </div>-->
      <!--                                </div>-->
      <!--                                <div class="ml-3" v-else>No System Requirements</div>-->
      <!--                                <div-->
      <!--                                    class="grid lg:grid-cols-1 p-1 text-2xl absolute bottom-0 text-center -left-96 text-white bg-danger w-1/2 service-box-left-belt">-->
      <!--                                    <div class="inline-block mr-2">-->
      <!--                                        &lt;!&ndash; <i class="fas fa-wrench inline-block" v-for="(n, i) in parseInt(service.complexity)"></i>&ndash;&gt;-->
      <!--                                        <a :href="service.guide.twitter" target="_blank"-->
      <!--                                           v-if="service.guide && service.guide.twitter !== null"><i-->
      <!--                                            class="fab fa-twitter inline-block transition duration-300 hover:text-theme-color"></i></a>-->
      <!--                                        <a :href="service.guide.telegram" target="_blank"-->
      <!--                                           v-if="service.guide && service.guide.telegram !== null"><i-->
      <!--                                            class="fab fa-telegram-plane inline-block transition duration-300 hover:text-theme-color"></i></a>-->
      <!--                                        <a :href="service.guide.website" target="_blank"-->
      <!--                                           v-if="service.guide && service.guide.website !== null"><i-->
      <!--                                            class="fas fa-globe inline-block transition duration-300 hover:text-theme-color"></i></a>-->
      <!--                                        <a :href="service.guide.facebook" target="_blank"-->
      <!--                                           v-if="service.guide && service.guide.facebook !== null"><i-->
      <!--                                            class="fab fa-facebook inline-block transition duration-300 hover:text-theme-color"></i></a>-->
      <!--                                    </div>-->
      <!--                                </div>-->

      <!--                                <div-->
      <!--                                    class="grid lg:grid-cols-1 p-1 text-2xl absolute bottom-0 text-center -right-96 bg-theme-color text-white w-1/2 service-box-right-belt">-->
      <!--                                    <div class="inline"><p class="inline w-auto px-1 text-lg"-->
      <!--                                                           v-for="type in service.types">-->
      <!--                                        {{ type.title }} </p></div>-->
      <!--                                </div>-->
      <!--                            </div>-->

      <!--                        </div>-->


      <!--                    </div>-->
      <!--                </a>-->
      <!--            </div>-->

      <!--            <a :href="'services/' + service.id" v-for="service in services"-->
      <!--               v-if="service.status === 'Ended' && goBack === true" class="animate__animated animate__fadeIn">-->
      <!--                <div-->
      <!--                    class="h-44 m-3 p-1 bg-white shadow-md rounded-lg transition duration-300 hover:shadow-xl relative overflow-hidden service-box pt-3">-->
      <!--                    <div class="h-8 w-40  transform -right-12 top-5 rotate-45 z-1 absolute"-->
      <!--                         :class="[(service.rating === 'not_rated' ? 'bg-gray-500' : 'bg-yellow-500'), (service.rating === 'promising' ? 'bg-yellow-500' : ''), (service.rating === 'high' ? 'bg-green-500' : '')] "-->
      <!--                    >-->
      <!--                        <p class="text-white  mt-2 text-center">{{ service.ratingTranslated }}</p>-->
      <!--                    </div>-->

      <!--                    <div class="">-->
      <!--                        <div class="h-24 service-logo pl-2 mx-auto float-left">-->
      <!--                            <img class="h-24 w-24 my-3 rounded-full"-->
      <!--                                 :src="'/'+service.logo">-->
      <!--                        </div>-->
      <!--                        <div class="float-left service-content text-left">-->
      <!--                            <h2 class="text-theme-color text-left ml-3 my-3 text-2xl title font-weight-bold">-->
      <!--                                {{ service.title }}</h2>-->

      <!--                            &lt;!&ndash;                        <h3 class="text-2xl mx-auto text-center"><span class="font-weight-bold">Rating:</span> <span  :class="[(service.rating === 'not_rated' ? 'text-gray-500' : 'text-yellow-500'), (service.rating === 'promising' ? 'text-yellow-500' : ''), (service.rating === 'high' ? 'text-green-500' : '')] ">{{service.ratingTranslated}}</span></h3>&ndash;&gt;-->
      <!--                            <div class="text-center w-full text-xl uppercase font-weight-bolder">{{ service.status }}-->
      <!--                            </div>-->
      <!--                            <div-->
      <!--                                class="grid lg:grid-cols-1 p-1 text-2xl absolute bottom-0 text-center -left-96 text-white bg-danger w-1/2 service-box-left-belt">-->
      <!--                                <div class="inline-block mr-2">-->
      <!--                                    &lt;!&ndash;<i class="fas fa-wrench inline-block"-->
      <!--                                                                  v-for="(n, i) in parseInt(service.complexity)"></i>&ndash;&gt;-->
      <!--                                    <a :href="service.guide.twitter" target="_blank"-->
      <!--                                       v-if="service.guide && service.guide.twitter !== null"><i-->
      <!--                                        class="fab fa-twitter inline-block transition duration-300 hover:text-theme-color"></i></a>-->
      <!--                                    <a :href="service.guide.telegram" target="_blank"-->
      <!--                                       v-if="service.guide && service.guide.telegram !== null"><i-->
      <!--                                        class="fab fa-telegram-plane inline-block transition duration-300 hover:text-theme-color"></i></a>-->
      <!--                                    <a :href="service.guide.website" target="_blank"-->
      <!--                                       v-if="service.guide && service.guide.website !== null"><i-->
      <!--                                        class="fas fa-globe inline-block transition duration-300 hover:text-theme-color"></i></a>-->
      <!--                                    <a :href="service.guide.facebook" target="_blank"-->
      <!--                                       v-if="service.guide && service.guide.facebook !== null"><i-->
      <!--                                        class="fab fa-facebook inline-block transition duration-300 hover:text-theme-color"></i></a>-->
      <!--                                </div>-->
      <!--                            </div>-->

      <!--                            <div-->
      <!--                                class="grid lg:grid-cols-1 p-1 text-2xl absolute bottom-0 text-center -right-96 bg-theme-color text-white w-1/2 service-box-right-belt">-->
      <!--                                <div class="inline"><p class="inline w-auto px-1 text-lg" v-for="type in service.types">-->
      <!--                                    {{ type.title }} </p></div>-->
      <!--                            </div>-->
      <!--                        </div>-->

      <!--                    </div>-->


      <!--                </div>-->
      <!--            </a>-->

    </div>
    <!--        <div class="w-full">-->
    <!--            <button-->
    <!--                class="block mx-auto bpy-1 px-2 bg-theme-color text-white text-xl rounded shadow-sm transition duration-300 hover:bg-red-700"-->
    <!--                v-if="loadMore" @click="load"><i class="fas fa-arrow-down"></i> Load More-->
    <!--            </button>-->
    <!--        </div>-->
  </div>
</template>

<script>
export default {
  data() {
    return {
      services: [],
      links: '',
      loadMore: true,
      test: [],
      goBack: false,
      active: true
    }
  },

  mounted() {
    this.getServices();
  },

  methods: {
    getServices() {
      var url = '/services';
      axios.get(url).then(response => {
        this.services = response.data.data;
        this.links = response.data.links;
      })
    },

    filterServices(status = null) {
      if (status === 'Ended'){
        this.active = false;
      }else{
        this.active = true;
      }
      var url = '/services?status=' + status;

      if (status === null) {
        url = '/services';
        this.goBack = false;
      }
      // if (status !== null && status === 'Ended') {
      //     this.goBack = true;
      // }
      axios.get(url).then(response => {
        this.services = response.data.data;
        this.links = response.data.links;
      })
    },

    load() {

      if (this.links.next === null) {
        this.loadMore = false;
        return false;
      }

      axios.get(this.links.next).then(response => {
        //this.services = response.data.data;
        this.links = response.data.links;
        if (this.links.next === null) {
          this.loadMore = false;
        }
        var data = this.services;
        $.each(response.data.data, function (key, value) {
          data.push(value);
        });
        this.services = data;
      })
    },

    isMobile() {
      if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        return true
      } else {
        return false
      }
    }

  }
}
</script>
