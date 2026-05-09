CREATE TABLE admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admin (username, password) 
VALUES ('admin', MD5('admin1234'));

CREATE TABLE places (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    region VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(100),
    features TEXT,
    activities TEXT,
    top_landmarks TEXT,
    main_image VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO places 
(name, region, description, location, features, activities, top_landmarks, main_image) 
VALUES

('الرياض', 'الرياض',
'عاصمة المملكة العربية السعودية تمتزج فيها الحداثة بالتراث العريق.',
'وسط المملكة',
'ناطحات سحاب, متاحف, حدائق',
'زيارة المتاحف, التسوق, رحلات تاريخية',
'برج المملكة, قصر المصمك, حديقة الحيوانات',
'images/riyadh/main.jpg'),

('مكة المكرمة', 'مكة المكرمة',
'أقدس مدينة في الإسلام وجهة المسلمين للحج والعمرة.',
'غرب المملكة',
'مسجد, تاريخ, ثقافة',
'الحج, العمرة, زيارة المعالم الدينية',
'المسجد الحرام, الكعبة المشرفة, جبل النور',
'images/makkah/main.webp'),

('العلا', 'المدينة المنورة',
'مدينة تاريخية تضم آثاراً نبطية ومعالم طبيعية فريدة.',
'شمال غرب المملكة',
'آثار, طبيعة, صحراء',
'استكشاف الآثار, تسلق الجبال, التصوير',
'مدائن صالح, العين, جبل الفيل',
'images/alula/main.webp'),

('الخبر', 'الشرقية',
'مدينة ساحلية حديثة تطل على الخليج العربي.',
'شرق المملكة',
'بحر, كورنيش, ترفيه',
'السباحة, المشي على الكورنيش, المطاعم',
'كورنيش الخبر, جزيرة أم الناعام, مول الراشد',
'images/alkhobar/main.jpg'),

('أبها', 'عسير',
'عاصمة منطقة عسير تشتهر بطبيعتها الخلابة وأجوائها الباردة.',
'جنوب المملكة',
'جبال, ضباب, طبيعة',
'التلفريك, السياحة الجبلية, المهرجانات',
'تلفريك أبها, منتزه عسير, قرية تنومة',
'images/abha/main.webp'),

('تبوك', 'تبوك',
'بوابة الشمال تمتلك إرثاً تاريخياً وطبيعة متنوعة.',
'شمال المملكة',
'تاريخ, بحر, جبال',
'الغوص, زيارة الآثار, التخييم',
'شاطئ مقنا, جبال تبوك, قلعة تبوك',
'images/tabuk/main.jpg');

CREATE TABLE gallery_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    place_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    image_order TINYINT DEFAULT 1,
    FOREIGN KEY (place_id) REFERENCES places(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO gallery_images (place_id, image_path, image_order) VALUES
(1, 'images/riyadh/gallery1.avif', 1),
(1, 'images/riyadh/gallery2.jpeg', 2),
(2, 'images/makkah/gallery1.png', 1),
(2, 'images/makkah/gallery2.png', 2),
(3, 'images/alula/gallery1.png', 1),
(3, 'images/alula/gallery2.png', 2);