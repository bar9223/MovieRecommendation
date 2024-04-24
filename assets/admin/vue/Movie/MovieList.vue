<template>
  <div class="component">
    <div>
      <table class="table table-bordered">
        <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Based on group</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(userGroup, index) in userGroups">
          <td>{{ userGroup.id }}</td>
          <td>
            <input v-model="userGroup.name" class="form-control" type="text" :disabled="userGroup.isDefault">
          </td>
          <td>
            <select v-if="!userGroup.isDefault" v-model="userGroup.basedOnGroup" class="form-control" :disabled="userGroup.isDefault">
              <option v-for="defaultGroup in defaultUserGroups" :value="defaultGroup">{{defaultGroup}}</option>
            </select>
          </td>
          <td>
            <button @click="deleteGroup(index)" v-if="!userGroup.isDefault" class="btn btn-sm btn-danger" title="Remove">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
    <section>
      <button :disabled="isSaving" type="button" class="btn btn-sm btn-primary mr-1" v-on:click="addGroup">
        <span>Add new group</span>
      </button>
      <button :disabled="isSaving" type="button" class="btn btn-sm btn-primary mr-1" v-on:click="save">
        <span v-if="isSaving">Saving...</span>
        <span v-if="!isSaving">Save user groups</span>
      </button>
    </section>
  </div>
</template>

<script>

export default {
  props: [],
  data() {
    const appData = JSON.parse(document.getElementById('vue-component-data').innerHTML);
    return {
      isSaving: false,
      userGroups: appData.userGroups,
      defaultUserGroups: appData.defaultUserGroups
    };
  },
  methods: {
    addGroup() {
        this.userGroups.push({
          id: null,
          name: 'new group',
          isDefault: false,
          basedOnGroup: 'default_forwarder'
        });
    },
    deleteGroup(index) {
      const removedUserGroup = this.userGroups.splice(index, 1);
      const id = removedUserGroup[0].id;

      const deleteUrl = window.location.pathname + '/' + id;
      this.$http.delete(deleteUrl)
          .then(() => {
            $.app.toast.success('Data has been deleted.');
          })
          .catch((error) => {
                $.app.toast.handleErrorResponse(error);
              }
          )
      ;
    },
    save() {
      this.isSaving = true;
      const postUrl = window.location.pathname;
      const postData = {
        userGroups: this.userGroups
      };
      this.$http.post(postUrl, postData)
          .then((response) => {
            if (response.data && response.data.data) {
              this.userGroups = response.data.data;
            }
            this.isSaving = false;
            $.app.toast.success('Data has been saved.');
          })
          .catch((error) => {
                $.app.toast.handleErrorResponse(error);
                this.isSaving = false;
              }
          )
      ;
    }
  }
}
</script>

<style scoped>

</style>