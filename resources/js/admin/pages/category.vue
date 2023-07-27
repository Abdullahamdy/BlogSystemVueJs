<template>
  <div>
    <div class="content">
      <div class="container-fluid">
        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
        <div
          class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
        >
          <p class="_title0">
            Categories
            <Button @click="addModal = true"
              ><Icon type="md-add" /> Add Category</Button
            >
          </p>

          <div class="_overflow _table_div">
            <table class="_table">
              <!-- TABLE TITLE -->
              <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Image</th>
                <th>Created at</th>
                <th>Action</th>
              </tr>
              <!-- TABLE TITLE -->

              <!-- ITEMS -->
              <tr
                v-for="(category, i) in categories"
                :key="category.id"
                v-if="categories.length > 0"
              >
                <td>{{ category.id }}</td>
                <td class="_table_name">{{ category.categoryName }}</td>
                <td ><img :src="category.iconImage" style="width: 50px;" alt=""></td>
                <td>{{ category.created_at }}</td>
                <td>

                  <Button
                    type="info"
                    size="small"
                    @click="showEditModal(category, i)"
                    >Edit</Button
                  >
                  <Button
                    @click="showDeletingModal(category, i)"
                    :loading="category.isDeleting"
                    type="error"
                    size="small"
                    >Delete</Button
                  >
                </td>
              </tr>
              <!-- ITEMS -->
            </table>
          </div>
        </div>
        <Modal
          v-model="addModal"
          title="Add Category"
          :mask-closable="false"
          :closable="false"
        >
          <Upload
          ref="uploads"
            type="drag"
            :headers="{
              'x-csrf-token': token,
              'X-Requested-With': 'XMLHttpRequest',
            }"
            :on-success="handleSuccess"
            :on-error="handleError"
            :format="['jpg', 'jpeg', 'png']"
            :max-size="2048"
            :on-format-error="handleFormatError"
            :on-exceeded-size="handleMaxSize"
            action="/app/upload"
          >
            <div style="padding: 20px 0">
              <Icon
                type="ios-cloud-upload"
                size="52"
                style="color: #3399ff"
              ></Icon>
              <p>Click or drag files here to upload</p>
            </div>
          </Upload>
          <div class="demo-upload-list" v-if="data.iconImage">
            <img :src="`${data.iconImage}`" />
            <div class="demo-upload-list-cover">
              <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
            </div>
          </div>

          <Input v-model="data.categoryName" placeholder="Add Category name" />

          <div slot="footer">
            <Button type="default" @click="addModal = false">Close</Button>
            <Button @click="addCategory" :disabled="isAdding" :loading="isAdding">{{
              isAdding ? "Adding ..." : "Add Category"
            }}</Button>
          </div>
        </Modal>
        <!-- edit modal -->
        <Modal
          v-model="editModal"
          title="edit Category"
          :mask-closable="false"
          :closable="false"
        >
        <Upload
        v-show="IsIconImageNew"
          ref="editDataUploads"
            type="drag"
            :headers="{
              'x-csrf-token': token,
              'X-Requested-With': 'XMLHttpRequest',
            }"
            :on-success="handleSuccess"
            :on-error="handleError"
            :format="['jpg', 'jpeg', 'png']"
            :max-size="2048"
            :on-format-error="handleFormatError"
            :on-exceeded-size="handleMaxSize"
            action="/app/upload"
          >
            <div style="padding: 20px 0">
              <Icon
                type="ios-cloud-upload"
                size="52"
                style="color: #3399ff"
              ></Icon>
              <p>Click or drag files here to upload</p>
            </div>
          </Upload>
          <Input v-model="editData.categoryName" placeholder="Edit category name" />
          <input type="hidden" v-model="editData.update" value="true">
          <div class="demo-upload-list" v-if="editData.iconImage">
            <img :src="`${editData.iconImage}`" />
            <div class="demo-upload-list-cover">
              <Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
            </div>
          </div>
          <div slot="footer">
            <Button type="default" @click="closeEditModal = false">Close</Button>
            <Button @click="editcategory" :disabled="isAdding" :loading="isAdding">{{
              isAdding ? "Editing ..." : "Edit category"
            }}</Button>
          </div>
        </Modal>

        <!-- delete alert modal -->
        <deleteModal></deleteModal>
      </div>
    </div>
  </div>
</template>

  <script>
  import deleteModal from "../components/deleteModal.vue";
  import { mapGetters } from "vuex";
export default {
  data() {
    return {
      data: {
        iconImage: "",
        categoryName: "",
      },
      addModal: false,
      editModal: false,
      isAdding: false,
      categories: [],
      editData: {
        categoryName: "",
        iconImage: "",
      },
      index: -1,
      showDeleteModal: false,
      isDeleting:false,
      deleteItem: {},
      deletingIndex: -1,
      token: "",
      IsIconImageNew:false,
      IsEditingItem : false,
    };
  },
  methods: {
    async addCategory() {
      if (this.data.categoryName.trim() == "") return this.e('category Name is required')
      if (this.data.iconImage.trim() == "") return this.e('Icon Image is required')
      this.data.iconImage =    `${this.data.iconImage}`
      const res = await this.callApi("post", "/app/create_category", this.data);
      if (res.status == 200) {
        this.categories.unshift(res.data.categroy);
        this.s("Category has been Added Successfully!");
        this.addModal = false;
        this.data.categoryName = "";
        this.data.iconImage = "";

      } else {

        if ((res.status = 422)) {

        } else {
          this.swr();
        }
      }
    },
    async deleteImage(isAdd = true) {
        let image ;
        if(!isAdd){
            console.log(2343)
            this.IsIconImageNew = true;
             image = this.editData.iconImage ;
            this.editData.iconImage = "";
            this.$refs.editDataUploads.clearFiles();
        }else{
             image = this.data.iconImage ;
            this.data.iconImage = "";
            this.$refs.uploads.clearFiles();
        }
      const res = await this.callApi("post", "/app/delete-img", {imageName:image,isAdd});
      if(res.status != 200){

        this.data.iconImage = image;
        this.swr();
      }
    },

    closeEditModal(){
        this.IsEditingItem = false,
        this.editModal = false

    },

    //edit data funciton
    async editcategory() {
      if (this.editData.categoryName.trim() == "")
        return this.e("category Name is required");
      const res = await this.callApi("post", "/app/edit_category", this.editData);
      if (res.status == 200) {
        this.categories[this.index].categoryName = this.editData.categoryName;
        this.categories[this.index].iconImage = this.editData.iconImage;
        this.s("category has been updated Successfully!");
        this.editModal = false;
      } else {
        if ((res.status = 422)) {
          if (res.data.errors.categoryName) {
            this.e(res.data.errors.categoryName[0]);
          }
        } else {
          this.swr();
        }
      }
    },

    //end edit data function

    async showEditModal(category, index) {
      let obj = {
        id: category.id,
        categoryName: category.categoryName,
        iconImage: category.iconImage,
      };

      this.editData = obj;
      this.editModal = true;
      this.index = index;
      this.IsEditingItem = true
    },
    /// end edit category

    //delete category



    showDeletingModal(category, i) {
      const deleteModalObj = {
        showDeleteModal: true,
        deleteUrl: "app/delete_category",
        data: category,
        deletingIndex: i,
        isDeleted: false
      };
      this.$store.commit("setDeletingModalObj", deleteModalObj);
       this.deletingIndex = i
    },
    //end delete category

    //file funciton

    handleSuccess(res, file) {
        res =   `/uploads/${res}`
        if(this.IsEditingItem){
            return  this.editData.iconImage = res;
        }
     return  this.data.iconImage = res;
    },
    handleError(res, file) {
      this.$Notice.warning({
        title: "file format is incorrect",
        desc: `${
          file.errors.file.length ? file.errors.file[0] : " Something wrong"
        }`,
      });
    },
    handleFormatError(file) {
      this.$Notice.warning({
        title: "The file format is incorrect",
        desc:
          "File format of " +
          file.name +
          " is incorrect, please select jpg or png.",
      });
    },
    handleMaxSize(file) {
      this.$Notice.warning({
        title: "Exceeding file size limit",
        desc: "File  " + file.name + " is too large, no more than 2M.",
      });
    },
  },
  components: {
    deleteModal
  },

  async created() {
    this.token = window.Laravel.csrfToken;
    const res = await this.callApi("get", "/app/get_categories");
    if (res.status == 200) {
      this.categories = res.data;
    } else {
      this.swr();
    }
  },
  computed: {
    ...mapGetters(["getDeleteModalObj"])
  },

  watch: {
    getDeleteModalObj(obj) {
      if (obj.isDeleted) {
        this.categories.splice(obj.deletingIndex, 1);
      }
    }
  }
};
</script>
