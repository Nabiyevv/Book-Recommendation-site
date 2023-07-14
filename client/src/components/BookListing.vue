<template>
  <div class="text-left ">
    <router-link :to="`/books/${book.id}`">
      <img :src="book.image ? IMGE_BASE_URL+book.image : `https://ssantanu505gmailcom.files.wordpress.com/2018/03/wp-1521478125466.jpg`" alt="Cover image" class="h-64 mb-2 hover:shadow-[rgba(0,_0,_0,_0.24)_5px_10px_10px]" />
      <!-- <img :src="book.image" alt="Cover image" class="h-64 mb-2" /> -->
    </router-link>
    <div>
      <router-link
        :to="`/books/${book.id}`"
        class="text-lg font-bold text-black hover:text-gray-700 mb-1 block"
      >
        {{ book.title }}
      </router-link>
      <div class="text-gray-800">{{ book.author }}</div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      IMGE_BASE_URL: import.meta.env.VITE_IMGE_BASE_URL,
    };
  },
  props: ["book"],
};
</script>
