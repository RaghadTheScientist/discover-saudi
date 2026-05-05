CREATE TABLE admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admin (username, password) 
VALUES ('admin', MD5('admin1234'));

CREATE TABLE regions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    direction VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample Data
INSERT INTO regions (name, direction, description) VALUES
('منطقة الرياض',   'وسطى',   'عاصمة المملكة ومركزها الإداري والاقتصادي'),
('منطقة مكة المكرمة', 'غربية', 'أقدس البقاع وجهة الحج والعمرة'),
('منطقة المدينة المنورة', 'غربية', 'ثاني أقدس البقاع الإسلامية'),
('المنطقة الشرقية', 'شرقية', 'مركز صناعة النفط والساحل الخليجي'),
('منطقة عسير',    'جنوبية', 'تشتهر بطبيعتها الجبلية وأجوائها الباردة'),
('منطقة تبوك',    'شمالية', 'بوابة الشمال بين الجبال والبحر الأحمر');

CREATE TABLE places (
    id INT PRIMARY KEY AUTO_INCREMENT,
    region_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(100),
    features TEXT,
    -- comma separated (e.g. "جبال, بحر, تاريخ")
    activities TEXT,
    -- comma separated (e.g. "تسلق, سباحة")
    top_landmarks TEXT,
    -- comma separated landmark names
    main_image VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE CASCADE
);


INSERT INTO places 
(region_id, name, description, location, features, activities, top_landmarks, main_image) 
VALUES

(1, 'الرياض',
'عاصمة المملكة العربية السعودية تمتزج فيها الحداثة بالتراث العريق.',
'وسط المملكة',
'ناطحات سحاب, متاحف, حدائق',
'زيارة المتاحف, التسوق, رحلات تاريخية',
'برج المملكة, قصر المصمك, حديقة الحيوانات',
'images/riyadh/main.jpg'),

(2, 'مكة المكرمة',
'أقدس مدينة في الإسلام وجهة المسلمين للحج والعمرة.',
'غرب المملكة',
'مسجد, تاريخ, ثقافة',
'الحج, العمرة, زيارة المعالم الدينية',
'المسجد الحرام, الكعبة المشرفة, جبل النور',
'images/makkah/main.webp'),

(2, 'العلا',
'مدينة تاريخية تضم آثاراً نبطية ومعالم طبيعية فريدة.',
'شمال غرب المملكة',
'آثار, طبيعة, صحراء',
'استكشاف الآثار, تسلق الجبال, التصوير',
'مدائن صالح, العين, جبل الفيل',
'images/alula/main.webp'),

(4, 'الخبر',
'مدينة ساحلية حديثة تطل على الخليج العربي.',
'شرق المملكة',
'بحر, كورنيش, ترفيه',
'السباحة, المشي على الكورنيش, المطاعم',
'كورنيش الخبر, جزيرة أم الناعام, مول الراشد',
'images/alkhobar/main.jpg'),

(5, 'أبها',
'عاصمة منطقة عسير تشتهر بطبيعتها الخلابة وأجوائها الباردة.',
'جنوب المملكة',
'جبال, ضباب, طبيعة',
'التلفريك, السياحة الجبلية, المهرجانات',
'تلفريك أبها, منتزه عسير, قرية تنومة',
'images/abha/main.webp'),

(6, 'تبوك',
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
);


INSERT INTO gallery_images (place_id, image_path, image_order) VALUES
(1, 'images/riyadh/gallery1.avif', 1),
(1, 'images/riyadh/gallery2.jpeg', 2),

(2, 'images/makkah/gallery1.png', 1),
(2, 'images/makkah/gallery2.png', 2),

(3, 'images/alula/gallery1.png', 1),
(3, 'images/alula/gallery2.png', 2),
