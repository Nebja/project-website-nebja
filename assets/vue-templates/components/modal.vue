<template>
  <div class="modal" :id="id" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" :id="id+'Title'">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" :id="id+'Body'">
        </div>
        <div class="modal-footer">
          <button v-if="btn!=='Logout'" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <form v-if="btn==='Delete'" action="/api/deleteAccount">
            <input name="id" id="id" :value="userId">
            <button type="submit" class="btn btn-primary">{{ btn }}</button>
          </form>
          <form v-if="btn==='Logout'" action="/logout">
            <button type="submit" class="btn btn-primary">{{ btn }}</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "modal",
  props:{
    id: null,
    btn: null,
    userId: null
  },
  methods:{
/*    deleteAccount(id){
      this.axios.get("/api/deleteAccount", {
        params:{
          'id': id
        }
      }).then((res) => {
        if (res.data['msg'] === 'success'){
          console.log(res.data['msg'])
          this.$emit('getModal', '', '', 'deleteModal', false)
          this.$emit('getModal', 'Account Process', 'Your account was Deleted proceed to Logout', 'logoutModal')
        }else {
          this.$emit('getModal', 'Account Process', res.data['msg'] , 'generalModal')
        }
      })
    }*/
  }
}
</script>

<style scoped>

</style>
