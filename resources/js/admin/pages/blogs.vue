<template>
    <div>
      <div class="content">
        <div class="container-fluid">
          <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
          <div
            class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
          >
            <p class="_title0">
              Blogs
              <Button @click="$router.push('/createblogs')"
              ><Icon type="md-add" /> Create Blogs</Button
              >
            </p>

            <div class="_overflow _table_div">
              <table class="_table">
                <!-- TABLE TITLE -->
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Tag</th>
                  <th>Categories</th>
                  <th>Views</th>
                  <th>Created at</th>
                  <th>Action</th>
                </tr>
                <!-- TABLE TITLE -->

                <!-- ITEMS -->
                <tr v-for="(blog, i) in blogs" :key="blog.id" v-if="blogs.length > 0">
                  <td>{{ blog.id }}</td>
                  <td class="_table_name">{{ blog.title }}</td>
                  <td ><span v-for="(t,i) in blog.tag" :key="i" v-if="blog.tag.length > 0"><Tag type="border">{{ t.tagName }}</Tag></span></td>
                  <td ><span v-for="(c,i) in blog.cat" :key="i" v-if="blog.cat.length > 0"><Tag type="border">{{ c.categoryName }}</Tag></span></td>
                  <td>{{ blog.views }}</td>
                  <td>{{ blog.created_at }}</td>
                  <td>
                    <Button
                      type="info"
                      size="small"
                      @click="showEditModal(blog, i)"
                    >Edit</Button
                    >
                    <Button
                    @click="showDeletingModal(blog,i)"
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



          <!-- delete alert modal -->
          <Modal
            :value="showDeleteModal"
            :mask-closable="false"
            :closable="false"
            width="360"
          >
            <p slot="header" style="color: #f60; text-align: center">
              <Icon type="ios-information-circle"></Icon>
              <span>Delete confirmation!</span>
            </p>
            <div style="text-align: center">
              <p>Are you sure Delete this Tag</p>
            </div>
            <div slot="footer">
              <Button type="default" size="large" @click="showDeleteModal = false"
                >Close</Button
              >
              <Button type="error" size="large"  :loading="isDeleting" :disabled="isDeleting" @click="Deleteblog">Deletee</Button>
            </div>
          </Modal>
        </div>
      </div>
    </div>
  </template>

  <script>
import {mapGetters} from 'vuex'
  export default {
    data() {
      return {

        isAdding: false,
        blogs: [],
        index: -1,
        showDeleteModal: false,
        isDeleting:false,
        deleteItem:{},
        DeletingIndex:-1,
      };
    },
    methods: {
        async Deleteblog() {

          this.isDeleting = true;
        const res = await this.callApi("post", "/app/delete_blog", this.deleteItem);
        if (res.status == 200) {
          this.blogs.splice(this.DeletingIndex, 1);
          this.s("Tag has been deleteted successfully");
        } else {
          this.swr();
        }
        this.isDeleting = false;
        this.showDeleteModal = false;
      },


      //end edit data function

      async showEditModal(tag, index) {
        let obj = {
          id: tag.id,
          tagName: tag.tagName,
        };

        this.editData = obj;
        this.editModal = true;
        this.index = index;
      },

      showDeletingModal(blog,i){
        console.log(i)
          this.deleteItem = blog;
          this.DeletingIndex = i;
          this.showDeleteModal = true;

      },
      //end delete tag
    },

    async created() {
      const res = await this.callApi("get", "/app/blogsdata");
      if (res.status == 200) {
        this.blogs = res.data;
      } else {
        this.swr();
      }
    },
    computed : {
		...mapGetters(['getDeleteModalObj'])
	},
  };
  </script>
