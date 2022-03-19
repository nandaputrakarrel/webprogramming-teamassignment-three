<template>
  <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        Product List
        <button @click="actionAdd">Add</button>
      </div>
      <div class="card-body">
          <table class="table">
              <thead>
                  <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Name</th>
                      <th scope="col">Description</th>
                      <th scope="col">Buy Price</th>
                      <th scope="col">Sell Price</th>
                      <th scope="col">Image</th>
                      <th scope="col">Action</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="item in items" :key="item.id">
                      <td>{{item.id}}</td>
                      <td>{{item.name}}</td>
                      <td>{{item.description}}</td>
                      <td>{{formatter.format(item.buyPrice)}}</td>
                      <td>{{formatter.format(item.sellPrice)}}</td>
                      <td><img :src="item.image || '/public/images/no-image.jpeg'" width="25px" height="25px"/></td>
                      <td>
                        <div class="d-flex">
                          <button @click="actionEdit(item)">Edit</button>
                          <button @click="actionDelete(item)">Delete</button>
                        </div>
                      </td>
                  </tr>
              </tbody>
          </table>
      </div>

      <modal name="product-modal" height="auto" scrollable>
        <b-form @submit.prevent="actionSubmit" class="p-2">
          <b-form-group
            id="groupProductName"
            label="Product Name :"
            label-for="productName"
            description="Enter the name of the product."
          >
            <b-form-input
              id="productName"
              v-model="selectedData.name"
              type="text"
              placeholder="Enter Product Name"
              required
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="groupProductDescription"
            label="Product Description :"
            label-for="productDescription"
            description="Enter the description of the product."
          >
            <b-form-input
              id="productDescription"
              v-model="selectedData.description"
              type="text"
              placeholder="Enter Product Description"
              required
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="groupBuyPrice"
            label="Buy Price :"
            label-for="buyPrice"
            description="Enter the buying price of the product."
          >
            <b-form-input
              id="buyPrice"
              v-model="selectedData.buyPrice"
              type="number"
              placeholder="Enter Buy Price"
              required
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="groupSellPrice"
            label="Sell Price :"
            label-for="sellPrice"
            description="Enter the selling price of the product."
          >
            <b-form-input
              id="sellPrice"
              v-model="selectedData.sellPrice"
              type="number"
              placeholder="Enter Sell Price"
              required
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="groupImage"
            label="Upload Image"
            label-for="image"
            description="Upload product's image"
          >
            <b-form-file
            v-model="image"
            :state="Boolean(image)"
            accept="image/*"
            placeholder="Choose a file or drop it here..."
            drop-placeholder="Drop file here..."
            size="sm"
            ></b-form-file>
          </b-form-group>

          <div class="d-flex justify-content-around w-100">
            <button class="mt-2">Save</button>
            <button class="mt-2" @click="actionCloseModal">Close</button>
          </div>
        </b-form>
      </modal>

      <modal name="delete-modal" height="auto">
        <div class="card-header">Are you sure to delete this product?</div>
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
  data () {
      return {
        items: null,
        formatter,
        isEditing: false,
        selectedData: {
          id: null
        },
        image: [],
        toastMessage: null,
      }
    },
  mounted () {
    this.fetchData();
  },
  methods: {
    fetchData() {
      axios
      .get('api/products')
      .then(response => (this.items = response.data))
    },
    actionAdd() {
      this.$modal.show('product-modal');
    },
    actionEdit(payload) {
      this.selectedData = {...payload};
      this.isEditing = true;
      this.$modal.show('product-modal')
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

          await axios.post(`/api/products/${this.selectedData.id}/update`, formData);
        } else {
          for (const key in this.selectedData) {
            if (Object.hasOwnProperty.call(this.selectedData, key)) {
              const element = this.selectedData[key];
              formData.append(key, element);
            }
          }
          await axios.post(`/api/products`, formData);
        }
      } catch (err) {
        console.log(err);
      } finally {
        this.actionCloseModal();
      }
    },
    async actionConfirmDelete() {
      await axios.post(`/api/products/${this.selectedData.id}/delete`);
      this.actionCloseDeleteModal();
    },
    actionCloseModal() {
      this.selectedData = {
        id: null
      };
      this.isEditing = false;
      this.$modal.hide('product-modal');
      this.fetchData();
    },
    actionCloseDeleteModal() {
      this.selectedData = {
        id: null
      };
      this.$modal.hide('delete-modal');
      this.fetchData();
    }
  }
}
</script>

<style>

</style>