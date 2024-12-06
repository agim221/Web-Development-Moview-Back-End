import pandas as pd
import psycopg2
import random

# Fungsi untuk memvalidasi URL Photo (berformat .jpg)
def is_valid_image_url(url):
    return isinstance(url, str) and url.endswith('.jpg')

# Fungsi untuk validasi Year (hanya satu tahun)
def is_valid_year(year):
    return isinstance(year, (int, float)) and not isinstance(year, bool)

# Fungsi untuk validasi Country (hanya satu entri)
def is_valid_country(country):
    return isinstance(country, str) and ',' not in country and '-' not in country

# Fungsi untuk mengubah YouTube link ke embed format
def convert_to_embed(trailer_url):
    if isinstance(trailer_url, str) and "youtube.com" in trailer_url:
        video_id = trailer_url.split("v=")[-1]
        return f"https://www.youtube.com/embed/{video_id}"
    return None

# Membaca dataset dari file
file_path = 'Dataset.xlsx'  # Sesuaikan path dengan file dataset Anda
xls = pd.ExcelFile(file_path)
main_dataset_df = pd.read_excel(xls, 'Main Dataset')
actor_df = pd.read_excel(xls, 'Actor')

# Cleansing Main Dataset
cleansed_main_dataset = main_dataset_df[
    main_dataset_df['Title'].notna() &
    main_dataset_df['URL Photo'].apply(is_valid_image_url) &
    main_dataset_df['Year'].apply(is_valid_year) &
    main_dataset_df['Country'].apply(is_valid_country) &
    main_dataset_df['Trailer(link YT)'].notna()
].copy()

# Mengubah trailer menjadi embed link
# cleansed_main_dataset['Trailer(link YT)'] = cleansed_main_dataset['Trailer(link YT)'].apply(convert_to_embed)

# Memisahkan Awards menjadi list jika lebih dari satu
cleansed_main_dataset['Award'] = cleansed_main_dataset['Award'].fillna('').str.split(',')

# Hanya menyimpan kolom yang diperlukan
cleansed_main_dataset = cleansed_main_dataset[
    ['Title', 'URL Photo', 'Year', 'Country', 'Synopsis', 'Availability', 'Genres (Up to 5)', 'Trailer(link YT)', 'Award']
]

# Cleansing Actor Dataset
cleansed_actor_df = actor_df[
    actor_df['Actor'].notna() &
    actor_df['PhotoURL'].apply(is_valid_image_url)
].copy()

# Fungsi untuk menyimpan ke PostgreSQL
def insert_into_postgresql(cleansed_main_dataset, cleansed_actor_df):
    # Koneksi ke database PostgreSQL
    conn = psycopg2.connect(
        host="localhost",  # Sesuaikan dengan host PostgreSQL Anda
        database="moview_backend",
        user="postgres",  # Sesuaikan dengan username PostgreSQL Anda
        password="zahran"  # Sesuaikan dengan password PostgreSQL Anda
    )
    cur = conn.cursor()

    # Memasukkan data ke tabel 'countries' dan 'years' jika belum ada
    for index, row in cleansed_main_dataset.iterrows():
        # Insert ke tabel countries (hapus ON CONFLICT)
        cur.execute("""
            INSERT INTO countries (name)
            VALUES (%s)
            ON CONFLICT DO NOTHING
            """, (row['Country'],)
        )

        # Insert ke tabel years (hapus ON CONFLICT)
        cur.execute("""
            INSERT INTO years (year)
            VALUES (%s)
            ON CONFLICT DO NOTHING
            """, (int(row['Year']),)
        )

        # Insert ke tabel genres (many-to-many)
        genres = row['Genres (Up to 5)'].split(', ')  # Misal genre dipisahkan dengan koma
        for genre in genres:
            cur.execute("""
                INSERT INTO genres (name)
                VALUES (%s)
                ON CONFLICT DO NOTHING
            """, (genre,))

        # Memasukkan data ke tabel films tanpa mengonversi link trailer
        cur.execute("""
            INSERT INTO films (title, image, description, release_date, rating, country_id, status, trailer, availability)
            VALUES (%s, %s, %s, %s, %s, 
                    (SELECT id FROM countries WHERE name=%s), %s, %s, %s)
            """, (
                row['Title'], row['URL Photo'], row['Synopsis'], int(row['Year']),
                random.randint(1, 5),  # Rating random dari 1-5
                row['Country'], random.randint(0, 1),  # Status random 0 atau 1
                row['Trailer(link YT)'], row['Availability']
            )
        )
    
    # Memasukkan data ke tabel 'actors' (hapus ON CONFLICT)
    for index, row in cleansed_actor_df.iterrows():
        cur.execute("""
            INSERT INTO actors (name, photo_url)
            VALUES (%s, %s)
            ON CONFLICT DO NOTHING
        """, (row['Actor'], row['PhotoURL']))
    
    # Commit dan tutup koneksi
    conn.commit()
    cur.close()
    conn.close()

# Panggil fungsi untuk memasukkan data ke PostgreSQL
insert_into_postgresql(cleansed_main_dataset, cleansed_actor_df)