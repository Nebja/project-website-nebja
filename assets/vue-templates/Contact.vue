<template>
  <div class="card bg-transparent border-0">
    <img class="background" ref="background" src="/img/bg/tag.jpg"  alt="bg"/>
    <!--Card content-->
    <div class="card-body text-white text-shadow mw-50 m-auto">

      <!--Section heading-->
      <h2 class="h1-responsive font-weight-bold text-center my-4">Contact Me</h2>
      <!--Section description-->
      <p class="text-center w-responsive mx-auto mb-5">Do you have any questions? Please do not hesitate to contact
        me directly.I will come back to you within a matter of hours.</p>

      <div class="row">

        <!--Grid column-->
        <div class="col-md-9 mb-md-0 mb-5">
          <form id="contact-form" name="contact-form" action="/api/sendEmail" method="POST">

            <!--Grid row-->
            <div class="row">

              <!--Grid column-->
              <div :class="this.viewData.user ? 'col-md-12':'col-md-6'">
                <div class="md-form mb-0">
                  <input v-if="this.viewData.user" :value="this.viewData.user" type="text" id="email" name="email" class="form-control" hidden>
                  <input type="text" id="name" name="name" class="form-control">
                  <label for="name" class="">Your name</label>
                </div>
              </div>
              <!--Grid column-->

              <!--Grid column-->
              <div class="col-md-6" v-if="!this.viewData.user">
                <div class="md-form mb-0">

                  <input v-else type="text" id="email" name="email" class="form-control">
                  <label for="email" class="">Your email</label>
                </div>
              </div>
              <!--Grid column-->

            </div>
            <!--Grid row-->

            <!--Grid row-->
            <div class="row">
              <div class="col-md-12">
                <div class="md-form mb-0">
                  <input type="text" id="subject" name="subject" class="form-control">
                  <label for="subject" class="">Subject</label>
                </div>
              </div>
            </div>
            <!--Grid row-->

            <!--Grid row-->
            <div class="row">

              <!--Grid column-->
              <div class="col-md-12">

                <div class="md-form">
                      <textarea type="text" id="message" name="message" rows="2"
                                class="form-control md-textarea"></textarea>
                  <label for="message">Your message</label>
                </div>

              </div>
            </div>
            <!--Grid row-->

          </form>

          <div class="text-center text-md-left">
            <a class="btn btn-primary" @click="sendMsg">Send</a>
          </div>
          <div class="status"></div>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-md-3 text-center">
          <ul class="list-unstyled mb-0">
            <li><i class="fas fa-map-marker-alt fa-2x"></i>
              <p>Berlin, 13351, Germany</p>
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
  props:['viewData'],
  methods:{
    sendMsg(e){
      e.preventDefault()
      let fd = new FormData
      fd.append('name',document.getElementById('name').value)
      fd.append('email',document.getElementById('email').value)
      fd.append('subject',document.getElementById('subject').value)
      fd.append('message',document.getElementById('message').value)
      this.axios.post('/api/sendEmail', fd).then((res) => {
        this.$emit('getModal','Email Process', res.data['msg'],'generalModal')
      })
    }
  },
  mounted() {
    console.log(this.viewData)
  }
}
</script>

<style scoped>

</style>
