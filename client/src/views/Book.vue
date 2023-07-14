<template>
  <ApolloQuery :query="gql => gql`${bookQuery}` " v-slot="{ result: { loading, error, data }, query, isLoading }">
    {{ console.log(data) }}
    <div v-if="isLoading">Loading ...</div>
    <div v-else-if="error">Error !</div>
    <div v-else-if="data" class="flex mt-16 flex-col lg:flex-row">
      <div>
        <img
          :src="data.book.image ? IMGE_BASE_URL + data.book.image : `https://ssantanu505gmailcom.files.wordpress.com/2018/03/wp-1521478125466.jpg`"
          alt="Cover image"
          class="h-80 mb-2 hover:shadow-[rgba(0,_0,_0,_0.24)_5px_10px_10px]"
        />
      </div>
      <div class="w-full lg:w-2/3 ml-0 mt-8 lg:mt-0 lg:ml-10">
          <div class="text-4xl font-bold">{{ data.book.title }}</div>
        <div class="text-2xl text-gray-700 mb-3">{{ data.book.author }}</div>
        <div class="text-2xl text-gray-700 mb-3">{{ data.book.category.name }}</div>
        <div class="text-lg text-gray-600 leading-normal">
          {{ data.book.description  }}
        </div>
        <div class="my-12">
          <a
            href="/books/id"
            class="border border-purple-600 border-solid rounded text-purple-600 px-4 py-4 hover:bg-purple-600 hover:text-white"
            >View Link</a
          >
        </div>
        <div class="flex gap-8 font-medium">
          <router-link :to="`/books/${data.book.id}/edit`" class="mr-2 hover:text-purple-600"
            >Edit</router-link
          >
          <a href="#"  @click.prevent="deleteBook()" class=" mr-2 hover:text-purple-600">Delete</a>
        </div>
      </div>
    </div>
  </ApolloQuery>
</template>

<script>
import { gql } from "graphql-tag";

export default {
  data() {
    return {
      IMGE_BASE_URL: import.meta.env.VITE_IMGE_BASE_URL,
      bookQuery: `query{
    book(id: ${this.$route.params.id}) {
    id
    title
    author
    description
    featured
    image
    link
    category {
      id
      name
    }
  }
}`,
    };
  },
  attrs:{
    dataId:String,
  },
  methods:{
    deleteBook(){
      this.$apollo.mutate({
        mutation: gql`
          mutation{
          deleteBook(id: ${this.$route.params.id}){
            id
            title
          }
        }`
      }).then((res)=>{
        console.log(res)
        this.$router.push('/');
      })
    }
  }

};
</script>

<style scoped>
.footer{
  position:static
}
</style>
