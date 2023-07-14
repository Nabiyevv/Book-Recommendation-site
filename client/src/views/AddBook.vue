<template>
  <div class="create container mt-12 mb-24">
    <h1 class="mb-4">Create Book</h1>
    <div>
      <div  v-if="resErrors" v-for="error of resErrors"
        class="max-w-xs bg-purple-500 text-white rounded-md shadow-lg mb-3 ml-3"
        role="alert"
      >
          <div class="flex p-2 text-bold">
        {{ error[0] }}
      </div>
      </div>
      
    </div>
    <form
      enctype="multipart/form-data"
      method="POST"
      @submit.prevent="addBook"
      class="w-full max-w-lg"
    >
      <div class="form-group">
        <label
          class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
          for="title"
          >Title</label
        >
        <input
          class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
          type="text"
          name="title"
          id="title"
          v-model="form.title"
        />
      </div>
      <div class="form-group">
        <label
          class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
          for="author"
          >Author</label
        >
        <input
          class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
          type="text"
          name="author"
          id="author"
          v-model="form.author"
        />
      </div>
      <div class="form-group">
        <label
          class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
          for="image"
          >Image</label
        >
        <input
          class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
          type="file"
          name="image"
          id="image"
          accept="image/png, image/jpeg, image/jpg"
          @change="fileHandler"
        />
        <div class="">
          <img
            class="h-64 mb-2 hover:shadow-[rgba(0,_0,_0,_0.24)_5px_10px_10px]"
            :src="previewImage"
            v-if="previewImage"
            alt="Preview Image"
          />
        </div>
      </div>

      <div class="form-group">
        <label
          class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
          for="description"
          >Description</label
        >
        <textarea
          class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
          name="description"
          id="description"
          cols="30"
          rows="10"
          v-model="form.description"
        ></textarea>
      </div>
      <div class="form-group">
        <label
          class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
          for="link"
          >Link</label
        >
        <input
          class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
          type="text"
          name="link"
          id="link"
          v-model="form.link"
        />
      </div>
      <div class="form-group">
        <label
          class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
          ><input
            type="checkbox"
            name="featured"
            v-model="form.featured"
            class="mr-2"
          />Featured</label
        >
      </div>
      <div class="form-group">
        <ApolloQuery
          :query="
            (gql) =>
              gql`
                ${categoryQuery}
              `
          "
          v-slot="{ result: { loading, error, data }, isLoading }"
        >
          <select
            name="category"
            id="category_id"
            v-model="form.category"
            class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
          >
            <option
              v-if="data"
              v-for="category of data['categories']"
              :key="category.id"
              :value="category.id"
            >
              {{ category.name }}
            </option>
          </select>
        </ApolloQuery>
      </div>

      <div class="form-group">
        <button type="submit">Add book</button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from "axios";
import { gql } from "graphql-tag";

export default {
  data() {
    return {
      form: {
        title: "",
        author: "",
        image: null,
        description: "",
        link: "",
        featured: false,
        category: 1,
      },
      resErrors: null,
      previewImage: "",
      categoryQuery: `
            query{
        categories{
          id
          name
        }
      }
      `,
    };
  },
  methods: {
    fileHandler(e) {
      this.form.image = e.target.files[0];
      console.log(this.form.image);
      const file = e.target.files[0];
      this.previewImage = URL.createObjectURL(file);
    },
    addBook() {
      console.log(this.form);
      axios
        .post("http://localhost:8000/api/addbook", this.form, {
          headers: {
            "Content-Type": "[multipart/form-data, application/json]",
            'Accept': 'application/json',
            'Acces-Control-Allow-Origin': '*',
            'Allow-Control-Allow-Methods': 'GET, POST, PUT, DELETE, OPTIONS',
            'Allow-Control-Allow-Headers': 'Content-Type, X-Auth-Token, Origin, Authorization',
          },
        })
        .then((res) => {
          alert("Book added successfully");
          console.log(res);
          this.$router.push("/");
        })
        .catch((err) => {
          // console.log(err.response);
          // console.log(import.meta.env.VITE_API_BASE_URL);
          this.resErrors = err.response.data.errors;
          console.log(this.resErrors);
        });
    },
  },
};
</script>

<style scoped>
.form-group {
  margin-bottom: 32px;
}
input[type="text"],
textarea {
  padding: 10px 14px;
  border: 1px solid lightgray;
  border-radius: 5px;
}

label {
  display: block;
}

button {
  padding: 16px;
  background: #027bff;
  color: white;
  border-radius: 5px;
  font-size: 16px;
}
.container {
  width: 100%;
  margin-right: auto;
  margin-left: auto;
  padding-right: 1rem;
  padding-left: 1rem;
}
</style>
