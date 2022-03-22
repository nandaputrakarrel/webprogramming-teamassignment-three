<template>
  <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        User List
        <button @click="actionAdd" v-if="isUserAdmin">Add</button>
      </div>
      <div class="card-body">
          <table class="table">
              <thead>
                  <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Gender</th>
                      <th scope="col">Birth Date</th>
                      <th scope="col" v-if="isUserAdmin">Action</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="item in items" :key="item.id">
                      <td>{{item.id}}</td>
                      <td>{{item.name}}</td>
                      <td>{{item.email}}</td>
                      <td>{{item.gender}}</td>
                      <td>{{item.birthdate}}</td>
                      <td v-if="isUserAdmin">
                        <div class="d-flex" >
                          <button @click="actionEdit(item)">Edit</button>
                          <button @click="actionDelete(item)">Delete</button>
                        </div>
                      </td>
                  </tr>
              </tbody>
          </table>
      </div>

      <modal name="user-modal" height="auto" scrollable>
        <b-form @submit.prevent="actionSubmit" class="p-2">
          <b-form-group
            id="groupUserName"
            label="User Name :"
            label-for="userName"
            description="Enter the name of the user."
          >
            <b-form-input
              id="userName"
              v-model="selectedData.name"
              type="text"
              placeholder="Enter User Name"
              required
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="groupUserEmail"
            label="User Description :"
            label-for="userEmail"
            description="Enter the email of the user."
          >
            <b-form-input
              id="userEmail"
              v-model="selectedData.email"
              type="email"
              placeholder="Enter User Email"
              required
            ></b-form-input>
          </b-form-group>

          <b-form-group label="Gender" v-slot="{ gender }">
            <b-form-radio v-model="selectedData.gender" :aria-describedby="gender" name="male" value="male">Male</b-form-radio>
            <b-form-radio v-model="selectedData.gender" :aria-describedby="gender" name="female" value="female">Female</b-form-radio>
          </b-form-group>

          <b-form-group
            id="groupBirthDate"
            label="Birth Date :"
            label-for="birthDate"
            description="Enter the birth date of the user."
          >
            <b-form-datepicker
              id="birthDate"
              v-model="selectedData.birthdate"
              type="date"
              placeholder="Enter User's Birth Date"
              size="sm"
              today-button
              reset-button
              close-button
              required
              dropright
            ></b-form-datepicker>
          </b-form-group>

          <b-form-group
            id="groupPassword"
            label="Password :"
            label-for="password"
            description="Enter password of the user."
          >
            <b-form-input
              id="password"
              v-model="selectedData.password"
              type="password"
              placeholder="Enter Password"
              required
              :state="isPasswordValid"
            ></b-form-input>

            <b-form-invalid-feedback id="input-live-feedback">
              Enter at least 8 letters
            </b-form-invalid-feedback>
          </b-form-group>

          <b-form-group
            id="groupPasswordConfirm"
            label="Re-type Password :"
            label-for="passwordConfirm"
            description="Re-type password of the user."
          >
            <b-form-input
              id="passwordConfirm"
              v-model="selectedData.passwordConfirm"
              type="password"
              placeholder="Re-type Password"
              required
              :state="isPasswordConfirmValid"
            ></b-form-input>

            <b-form-invalid-feedback id="input-live-feedback">
              Enter at least 8 letters and match the password
            </b-form-invalid-feedback>
          </b-form-group>

          <div class="d-flex justify-content-around w-100">
            <button class="mt-2">Save</button>
            <button class="mt-2" @click="actionCloseModal">Close</button>
          </div>
        </b-form>
      </modal>

      <modal name="delete-modal" height="auto">
        <div class="card-header">Are you sure to delete this user?</div>
        <div class="d-flex justify-content-around card-body">
            <button class="mt-2" @click="actionConfirmDelete">Delete</button>
            <button class="mt-2" @click="actionCloseDeleteModal">Close</button>
          </div>
      </modal>
  </div>
</template>

<script>
import formatter from '../../formatter';

export default {
  props: ['user'],
  data () {
      return {
        items: null,
        formatter,
        isEditing: false,
        selectedData: {
          id: null,
          email: null,
          password: "",
          passwordConfirm: "",
        },
        image: [],
        toastMessage: null,
      }
    },
  mounted () {
    this.fetchData();
  },
  computed: {
    isUserAdmin() {
      return this.user.roleId == 1;
    },
    isPasswordValid() {
      return this.selectedData.password.length > 7 ? true : false
    },
    isPasswordConfirmValid() {
      return this.selectedData.passwordConfirm.length > 7 && this.selectedData.password === this.selectedData.passwordConfirm ? true : false
    }
  },
  methods: {
    fetchData() {
      axios
      .get('api/users')
      .then(response => (this.items = response.data))
    },
    actionAdd() {
      this.$modal.show('user-modal');
    },
    actionEdit(payload) {
      this.selectedData = {...payload};
      this.isEditing = true;
      this.$modal.show('user-modal')
    },
    actionDelete(payload) {
      this.selectedData = {...payload};
      this.$modal.show('delete-modal')
    },
    async actionSubmit() {
      try {
        const formData = new FormData();
        console.log(this.image)
        if (this.image instanceof File) {
          formData.append('image', this.image);
        }

        if (this.isEditing) {
          for (const key in this.selectedData) {
            if (Object.hasOwnProperty.call(this.selectedData, key)) {
              const element = this.selectedData[key];
              formData.append(key, element);
            }
          }

          await axios.post(`/api/users/${this.selectedData.email}/update`, formData);
        } else {
          for (const key in this.selectedData) {
            if (Object.hasOwnProperty.call(this.selectedData, key)) {
              const element = this.selectedData[key];
              formData.append(key, element);
            }
          }
          await axios.post(`/api/users`, formData);
        }
      } catch (err) {
        console.log(err);
      } finally {
        this.actionCloseModal();
      }
    },
    async actionConfirmDelete() {
      await axios.post(`/api/users/${this.selectedData.email}/delete`);
      this.actionCloseDeleteModal();
    },
    actionCloseModal() {
      this.selectedData = {
        id: null,
        email: null,
        password: "",
        passwordConfirm: "",
      };
      this.isEditing = false;
      this.$modal.hide('user-modal');
      this.fetchData();
    },
    actionCloseDeleteModal() {
      this.selectedData = {
        id: null,
        email: null,
        password: "",
        passwordConfirm: "",
      };
      this.$modal.hide('delete-modal');
      this.fetchData();
    }
  }
}
</script>

<style>

</style>