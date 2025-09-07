Data OrderProduct :

-   id_produk
-   nama_produk
-   ukuran
-   desain (nullable)
-   waktu_mulai
-   waktu_selesai
-   gambar_proses (nullable)
-   selesai : boolean
-   : one to many ke table material yang dibutuhkan : jadi table [OrderProduct] ---> [Bahan ] <--- [Barang]

---

-   nama_produk
-   ukuran
-   desain : FILE
-   waktu_mulai
-   waktu_selesai
-   gambar_proses : FILE
-   : one to many ke table material yang dibutuhkan : jadi table [OrderProduct] ---> [Bahan ] <--- [Barang]

---

Worker :

-   id: uniqe foreign key
-   id: order_product. primary key
-   id: tukang. primary key

---

Comunication :

-   id
-   id_users(tukang)
-   worker.
-   messeage

Material

-   id
-   id_worker
-   id_item
-   jumlah
