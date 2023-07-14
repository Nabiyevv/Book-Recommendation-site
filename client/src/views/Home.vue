<template>
  <Hero />
  <div class="container flex mt-24 items-start justify-between">
    <div class="flex flex-wrap mr-8">
      <div class="w-full px-4">
        <ApolloQuery 
          :query="(gql) => categoriesQuery()"
          v-slot="{ result: { loading, error, data }, query, isLoading }"
        >
          <!-- {{ console.log(data) }} -->
          <div v-if="isLoading">Loading...</div>
          <div v-else-if="error" class="error apollo">An error occurred</div>
          <ul
            v-else-if="data"
            class="list-reset text-base font-bold text-gray-800"
          >
            <li class="mb-6">
              <a @click.prevent="selectCategory('all')" href="#" :class="selectedCategory === 'all' ? 'text-purple-600' : 'hover:text-red-900'" class="hover:text-grey-darkest">All</a>
            </li>
            <li class="mb-6">
              <a href="#" @click.prevent="selectCategory('featured')" :class="selectedCategory === 'featured' ? 'text-purple-600' : 'hover:text-red-900'" class="hover:text-grey-darkest">Featured</a>
            </li>
            <li
              v-for="category of data['categories']"
              :key="category.id"
              class="mb-6"
            >
              <a
                href="#"
                :class="selectedCategory === category.id ? 'text-purple-600' : 'hover:text-red-900'"
                @click.prevent="selectCategory(category.id)"
                class="hover:text-grey-darkest"
                >{{ category.name }}</a
              >
            </li>
            <li class="mb-6 text-red-600">
              <RouterLink :to="`/books/add`" class="hover:text-grey-darkest"
                >Add Book</RouterLink
              >
            </li>
          </ul>
          <div v-else class="no-result apollo">No result :(</div>
        </ApolloQuery>
        
      </div>
      <div class="w-full lg:w-3/4 px-4 mb-12">
        <div></div>
      </div>
    </div>

    <!-- Book Listing -->
    <div class="w-full lg:w-3/4 px-4 mb-12">
      <div>
        <ApolloQuery v-if="selectedCategory === 'all'"
          :query="
            (gql) =>
              gql`
                ${booksQuery}
              `
          "
          v-slot="{ result: { loading, error, data }, query, isLoading }"
        >
          <div class="flex flex-wrap">
            <!-- {{ data }} -->
            <div v-if="isLoading">Loading ...</div>
            <div v-else-if="error">Error !</div>
            <div 
            v-else-if="data"
            v-for="book of data['books']['data']"
            class="w-full md:w-1/2 lg:w-1/3 px-4 mb-12"
            >
            <BookListing :book="book" />
          </div>
          <!-- <div v-else-if="data">Error !</div> -->
          </div>
        </ApolloQuery>
        <ApolloQuery v-else-if="selectedCategory === 'featured'"
        :query="
            (gql) =>
              gql`
                ${featuredQuery}
              `
          "
          v-slot="{ result: { loading, error, data }, query, isLoading }"
        >
          <div class="flex flex-wrap ">
            <!-- {{ data }} -->
            <div v-if="isLoading">Loading ...</div>
            <div v-else-if="error">Error !</div>
            <div 
            v-else-if="data"
            v-for="book of data['featured']['data']"
            class=" md:w-1/2 lg:w-1/3 px-4 mb-12"
            >
            <BookListing :book="book" />
          </div>
          <!-- <div v-else-if="data">Error !</div> -->
          </div>
        </ApolloQuery>
        <ApolloQuery v-else
          :query="
            (gql) =>
              gql`
                ${newQuery}
              `
          "
          v-slot="{ result: { loading, error, data }, query, isLoading }"
        >
          <div class="flex flex-wrap">
            <div v-if="isLoading">Loading ...</div>
            <div v-else-if="error">Error !</div>
            <div
              v-else-if="data"
              v-for="book of data['category']['books']"
              class="w-full md:w-1/2 lg:w-1/3 px-4 mb-12"
            >
              <BookListing :book="book" />
            </div>
          </div>
          <div class="text-2xl" v-if="!isLoading && data['category']['books'].length==0">{{ `We dont have any ${data["category"].name} book!` }}</div>
        </ApolloQuery>
      </div>
    </div>
  </div>
</template>
<script>
import Hero from "../components/Hero.vue";
import BookListing from "../components/BookListing.vue";
import categoriesQuery from "../graphql/queries/categories";
import { ApolloQuery } from "@vue/apollo-components";
// import books_Query from "../graphql/queries/books.gql";

import gql from "graphql-tag";

export default {
  data() {
    return {
      categoriesQuery,
      selectedCategory: "all",
      newQuery:`sss`,
      booksQuery: `query{
                books{
            data{
              id
              title
              author
              image
              featured
            }
            paginatorInfo
            {
              currentPage
              lastPage
              total
            }
          }
        }`,
        featuredQuery: `query{
          featured {
            data{
            id
            title
            author
            image
            }
          }
        }`
    };
  },
  methods: {
    selectCategory(id) {
      this.selectedCategory = id;
      this.newQuery = `query {
          category(id: ${id}) {
            id
            name
            books {
              id
              title
              author
              image
              featured
              }
            }
          }`
    },
  },
  components: {
    Hero,
    BookListing,
    ApolloQuery,
  },
};
</script>

<style></style>
