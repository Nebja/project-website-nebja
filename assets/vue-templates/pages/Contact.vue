<template>
  <div class="card bg-transparent border-0">
    <img class="background" ref="background" src="/img/bg/tag.jpg"  alt="bg"/>
    <!--Card content-->
    <div class="card-body text-white text-shadow mw-50 m-auto">

      <!--Section heading-->
      <h2 class="h1-responsive font-weight-bold text-center my-4" v-html="trans['contactPage.title']"></h2>
      <!--Section description-->
      <p class="text-center w-responsive mx-auto mb-5" v-html="trans['contactPage.text']"></p>

      <div class="row">

        <!--Grid column-->
        <div class="col-md-9 mb-md-0 mb-5">
          <form id="contact-form" name="contact-form" action="/api/sendEmail" method="POST">

            <!--Grid row-->
            <div class="row">

              <!--Grid column-->
              <div :class="this.viewData.user ? 'col-md-12':'col-md-6'">
                <div class="md-form mb-0">
                  <input v-if="this.viewData.user" v-model="email" data-name="email" type="text" id="email" name="email" class="form-control" hidden>
                  <input type="text" id="name" name="name" v-model="name" data-name="name" class="form-control">
                  <label for="name" class="">{{ trans.name }}</label>
                </div>
              </div>
              <!--Grid column-->

              <!--Grid column-->
              <div class="col-md-6" v-if="!this.viewData.user">
                <div class="md-form mb-0">
                  <input type="text" id="email" v-model="email" data-name="email" name="email" class="form-control">
                  <label for="email" class="">{{ trans.email }}</label>
                </div>
              </div>
              <!--Grid column-->

            </div>
            <!--Grid row-->

            <!--Grid row-->
            <div class="row">
              <div class="col-md-12">
                <div class="md-form mb-0">
                  <input type="text" id="subject" v-model="subject" data-name="subject" name="subject" class="form-control">
                  <label for="subject" class="">{{ trans.subject }}</label>
                </div>
              </div>
            </div>
            <!--Grid row-->

            <!--Grid row-->
            <div class="row">

              <!--Grid column-->
              <div class="col-md-12">

                <div class="md-form">
                      <textarea type="text" id="message" data-name="message" v-model="message" name="message" rows="2"
                                class="form-control md-textarea"></textarea>
                  <label for="message">{{ trans.msg }}</label>
                </div>

              </div>
            </div>
            <!--Grid row-->

          </form>

          <div class="text-center text-md-left">
            <a class="btn btn-primary" @click="sendMsg">{{ trans.send }}</a>
          </div>
          <div class="status"></div>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-md-3 text-center">
          <ul class="list-unstyled mb-0">
            <li><i class="fas fa-map-marker-alt fa-2x"></i>
              <p>{{ trans.address }}</p>
            </li>

            <li><i class="fas fa-phone mt-4 fa-2x"></i>
              <p>+49 3054810329</p>
            </li>

            <li><i class="fas fa-envelope mt-4 fa-2x"></i>
              <p>nebwebsites@nebja.eu</p>
            </li>
          </ul>
        </div>
        <!--Grid column-->

      </div>

    </div>

  </div>
</template>

<script>
export default {
  name: "Contact",
  props:['viewData', 'trans'],
  data(){
    return {
      message: null,
      name: null,
      email: this.viewData.user,
      subject: null
    }
  },
  methods:{
    sendMsg(e){
      e.preventDefault()
      if (!this.email){
        this.$getModal('Email Process', 'Email is required.', 'generalModal')
        return
      }else if (!this.name){
        this.$getModal('Email Process', 'Name is required.', 'generalModal')
        return
      }else if(!this.subject || !this.message){
        this.$getModal('Email Process', 'Subject and Message text is required.', 'generalModal')
        return
      }else if (!this.validEmail(this.email)){
        this.$getModal('Email Process', 'Valid Email is required. ', 'generalModal')
        return
      }
      let fd = this.$CreateFD("contact-form")
      this.$SendEmail(fd).then((res) => {
        this.$getModal('Email Process', res.data['msg'],'generalModal')
      })
    },
    validEmail(email) {
      let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    }
  }
}
</script>

<style scoped>

</style>
