// ============================================================
// LogTea — i18n Language Manager (AR ↔ EN)
// ============================================================

(function () {
  // ── Bootstrap: set direction ASAP to prevent flash ─────────
  const _stored = localStorage.getItem('lt_lang') || 'ar';
  document.documentElement.lang = _stored;
  document.documentElement.dir = _stored === 'ar' ? 'rtl' : 'ltr';
  document.documentElement.setAttribute('data-lang', _stored);

  // ── English Translations ────────────────────────────────────
  // Keys match [data-i18n] / [data-i18n-html] / [data-i18n-ph] attributes.
  // Arabic text lives in the HTML; we only store English here.
  const EN = {

    /* ── COMMON ── */
    'logo.tagline'        : 'We write the code.. We craft the solutions',
    'nav.home'            : 'Home',
    'nav.about'           : 'About Us',
    'nav.services'        : 'Services',
    'nav.portfolio'       : 'Our Work',
    'nav.blog'            : 'Blog',
    'nav.contact'         : 'Contact',
    'nav.cta'             : 'Get Started ↗',
    'footer.desc'         : 'A specialized software company that transforms your ideas into smart digital solutions using the latest technologies and best global practices.',
    'footer.col1'         : 'Services',
    'footer.col2'         : 'Company',
    'footer.col3'         : 'Newsletter',
    'footer.nl.desc'      : 'Subscribe to get the latest articles and tech news',
    'footer.nl.ph'        : 'Your email address',
    'footer.nl.btn'       : '→ Subscribe',
    'footer.badge1'       : '✓ No spam',
    'footer.badge2'       : '✓ Unsubscribe anytime',
    'footer.copy'         : '© 2026 LogTea. All rights reserved.',
    'footer.privacy'      : 'Privacy Policy',
    'footer.terms'        : 'Terms & Conditions',
    'footer.support'      : 'Support',

    /* ── INDEX ── */
    'index.title'         : 'LogTea | We Write the Code.. We Craft the Solutions',
    'index.hero.badge'    : 'Specialized Tech Company Since 2019',
    'index.hero.title'    : 'We write the <span class="text-teal">code</span><br/><span class="text-outline">We craft</span> <span class="text-teal">solutions</span>',
    'index.hero.desc'     : 'We transform your ideas into smart digital solutions using the latest technologies and best global practices',
    'index.hero.btn1'     : 'Start Your Project',
    'index.hero.btn2'     : 'See Our Work',
    'index.hero.s1'       : 'Happy Clients',
    'index.hero.s2'       : 'Completed Projects',
    'index.hero.s3'       : 'Years of Experience',
    'index.svc.tag'       : 'Our Services',
    'index.svc.title'     : 'Comprehensive <span class="text-teal">Tech Solutions</span>',
    'index.svc.desc'      : 'We offer a wide range of integrated technology services',
    'index.svc.all'       : 'View All Services →',
    'index.ai.name'       : 'AI Solutions',
    'index.ai.ar'         : 'Artificial Intelligence Solutions',
    'index.ai.desc'       : 'Custom AI models, natural language processing, computer vision and intelligent automation',
    'index.ai.link'       : 'Learn more ←',
    'index.web.name'      : 'Web Development',
    'index.web.ar'        : 'Full-Stack Web Development',
    'index.web.desc'      : 'Modern, fast and secure websites and web applications using the latest frameworks',
    'index.web.link'      : 'Learn more ←',
    'index.sec.name'      : 'Cyber Security',
    'index.sec.ar'        : 'Advanced Cyber Security',
    'index.sec.desc'      : 'Penetration testing, security audits, data protection and vulnerability management',
    'index.sec.link'      : 'Learn more ←',
    'index.cloud.name'    : 'Cloud Services',
    'index.cloud.ar'      : 'Cloud Services',
    'index.cloud.desc'    : 'Deploy and manage cloud infrastructure on AWS, Azure and GCP with efficiency and security',
    'index.cloud.link'    : 'Learn more ←',
    'index.api.name'      : 'APIs & Integrations',
    'index.api.ar'        : 'APIs & Integrations',
    'index.api.desc'      : 'Design and develop robust APIs and third-party integrations to connect your business',
    'index.api.link'      : 'Learn more ←',
    'index.db.name'       : 'Database Solutions',
    'index.db.ar'         : 'Database Solutions',
    'index.db.desc'       : 'Design and manage relational and non-relational databases with highest performance standards',
    'index.db.link'       : 'Learn more ←',
    'index.stats.l1'      : 'Happy Client',
    'index.stats.l2'      : 'Completed Project',
    'index.stats.l3'      : 'Years of Experience',
    'index.stats.l4'      : 'Technical Support',
    'index.about.tag'     : 'About Us',
    'index.about.title'   : 'Building the <span class="text-teal">Digital Future</span>',
    'index.about.desc'    : 'LogTea is a specialized software company that combines technical creativity with deep understanding of our clients\' needs. We believe every idea deserves to be transformed into a polished digital solution that makes a real difference.',
    'index.about.btn'     : 'Learn More About Us',
    'index.about.v1'      : 'Innovation',
    'index.about.v1s'     : 'Latest technologies',
    'index.about.v2'      : 'Quality',
    'index.about.v2s'     : 'Clean & reliable code',
    'index.about.v3'      : 'Security',
    'index.about.v3s'     : 'Your data is safe',
    'index.about.v4'      : 'Speed',
    'index.about.v4s'     : 'We meet deadlines',
    'index.port.tag'      : 'Our Work',
    'index.port.title'    : 'Projects We <span class="text-teal">Are Proud Of</span>',
    'index.port.desc'     : 'Samples of our latest projects that made a real difference',
    'index.port.all'      : 'View All Projects →',
    'index.port.c1'       : 'Smart Business Management Platform',
    'index.port.d1'       : 'An integrated ERP system with real-time AI analytics, interactive dashboards and smart reports',
    'index.port.r1'       : '↑ 45% operational efficiency',
    'index.port.l1'       : 'Details ←',
    'index.port.c2'       : 'Security Audit for a Digital Bank',
    'index.port.d2'       : 'Comprehensive penetration testing and security assessment for a digital banking platform',
    'index.port.r2'       : '47 vulnerabilities fixed',
    'index.port.l2'       : 'Details ←',
    'index.port.c3'       : 'Cloud Migration for Logistics Company',
    'index.port.d3'       : 'Full migration of 30+ servers to AWS with 40% cost reduction',
    'index.port.r3'       : '↑ 300% performance boost',
    'index.port.l3'       : 'Details ←',
    'index.port.c4'       : 'Integrated E-Learning Platform',
    'index.port.d4'       : 'Full-featured web application with a smart recommendation system',
    'index.port.r4'       : '10K+ active users',
    'index.port.l4'       : 'Details ←',
    'index.test.tag'      : 'Client Testimonials',
    'index.test.title'    : 'What Our <span class="text-teal">Clients Say</span>',
    'index.test.q1'       : '"LogTea turned our idea into an amazing product in record time. The code is clean and results exceed our expectations."',
    'index.test.n1'       : 'Ahmed Al-Mahmoud',
    'index.test.r1'       : 'Founder, TechStart',
    'index.test.q2'       : '"The security solution provided by LogTea saved us from serious vulnerabilities. A very professional and reliable team."',
    'index.test.n2'       : 'Sarah Al-Rashid',
    'index.test.r2'       : 'CTO at Fintech Arabia',
    'index.test.q3'       : '"The cloud migration was a huge challenge but LogTea completed it smoothly with a remarkable performance improvement."',
    'index.test.n3'       : 'Khalid Al-Omari',
    'index.test.r3'       : 'COO at LogiCo',
    'index.blog.tag'      : 'Blog',
    'index.blog.title'    : 'Latest <span class="text-teal">Articles</span>',
    'index.blog.b1'       : 'The Future of AI in Software Development',
    'index.blog.d1'       : 'How large AI models are changing the way code is written and systems are designed...',
    'index.blog.l1'       : 'Read more ←',
    'index.blog.b2'       : 'OWASP Top 10: How to Protect Your Application',
    'index.blog.d2'       : 'A comprehensive guide to understanding the most dangerous security vulnerabilities...',
    'index.blog.l2'       : 'Read more ←',
    'index.blog.b3'       : 'Kubernetes vs Docker Swarm: Which to Choose?',
    'index.blog.d3'       : 'A detailed comparison between the two leading container management platforms...',
    'index.blog.l3'       : 'Read more ←',
    'index.blog.all'      : 'Read All Articles →',
    'index.cta.title'     : 'Have a project idea? <span class="text-teal">Let\'s build it together</span>',
    'index.cta.desc'      : 'Our team is ready to listen and turn your vision into a polished digital solution',
    'index.cta.btn1'      : 'Contact Us Now',
    'index.cta.btn2'      : 'Explore Services',

    /* ── ABOUT ── */
    'about.title'         : 'LogTea | About Us',
    'about.bread'         : 'About Us',
    'about.banner.title'  : 'We write the code<br/><span class="text-teal">We craft the solutions</span>',
    'about.banner.desc'   : 'A technology company that believes every idea deserves to be turned into a polished digital reality that makes a real difference in people\'s lives and business',
    'about.banner.s1'     : 'Happy Clients',
    'about.banner.s2'     : 'Completed Projects',
    'about.banner.s3'     : 'Years of Experience',
    'about.banner.s4'     : 'Specialized Technologies',
    'about.story.tag'     : 'Our Story',
    'about.story.title'   : 'Why <span class="text-teal">LogTea</span>?',
    'about.story.p1'      : 'The story began in 2019 with a genuine passion for technology and an honest desire to make a difference. Just like a great cup of tea is made from the finest leaves with care and attention — we craft our software solutions with the same precision and dedication.',
    'about.story.p2'      : '"Log" represents the code logs we write daily, and "Tea" is the energy and creativity we infuse into every project. We believe programming is an art before it\'s a science, and every line of code is an opportunity to create something beautiful.',
    'about.story.p3'      : 'Today, our team of developers, engineers and designers works hand in hand to deliver comprehensive tech solutions that accelerate our clients\' business growth.',
    'about.story.btn1'    : 'Start With Us',
    'about.story.btn2'    : 'See Our Work',
    'about.mv.tag'        : 'Mission & Vision',
    'about.mv.title'      : 'We believe <span class="text-teal">technology</span> changes the world',
    'about.mission.title' : 'Our Mission',
    'about.mission.desc'  : 'To empower individuals and organizations to achieve their digital goals through innovative and reliable software solutions, built on a genuine partnership of transparency and mutual trust.',
    'about.vision.title'  : 'Our Vision',
    'about.vision.desc'   : 'To become the first technology partner that companies and institutions in the Arab region turn to when they want to transform their ideas into world-class competitive digital products.',
    'about.val.tag'       : 'Our Values',
    'about.val.title'     : 'What <span class="text-teal">Sets Us Apart</span>',
    'about.v1.title'      : 'Innovation First',
    'about.v1.desc'       : 'We embrace the latest technologies and experiment constantly. Staying ahead is not a choice but a necessity in the fast-paced world of technology.',
    'about.v2.title'      : 'Quality is Non-Negotiable',
    'about.v2.desc'       : 'We write code we\'re proud of. Every line passes rigorous review, every feature is carefully tested. Quality is not an extra cost — it\'s our starting point.',
    'about.v3.title'      : 'True Partnership',
    'about.v3.desc'       : 'We treat our clients\' projects as if they were our own. We succeed together or learn together. Your success is our success.',
    'about.v4.title'      : 'Security at Every Step',
    'about.v4.desc'       : 'Security is not an add-on — it\'s the foundation of everything we build. From the first line of code to launch and beyond.',
    'about.v5.title'      : 'Speed & Efficiency',
    'about.v5.desc'       : 'We believe in Agile and we practice it. Early delivery, fast feedback, continuous improvement. Your time is precious and we know it.',
    'about.v6.title'      : 'Sustainable Growth',
    'about.v6.desc'       : 'We build solutions that grow with your business. Every technical decision we make is built for sustainability and future scalability.',
    'about.team.tag'      : 'Our Team',
    'about.team.title'    : 'The Minds That <span class="text-teal">Make the Magic</span>',
    'about.team.desc'     : 'A diverse team of engineers and creators who share one passion: building remarkable technology',
    'about.t1.name'       : 'Mohammed Al-Shahri',
    'about.t1.role'       : 'CEO & Co-Founder',
    'about.t1.bio'        : 'Software engineer with 12 years of experience, specializing in distributed systems architecture and leading technical teams',
    'about.t2.name'       : 'Noura Al-Qahtani',
    'about.t2.role'       : 'CTO & AI Lead',
    'about.t2.bio'        : 'PhD in Artificial Intelligence, led 30+ ML projects across diverse sectors',
    'about.t3.name'       : 'Ali Al-Ghamdi',
    'about.t3.role'       : 'Lead Backend Engineer',
    'about.t3.bio'        : 'Specialist in Node.js and Python, building high-performance scalable systems',
    'about.t4.name'       : 'Reem Al-Dosari',
    'about.t4.role'       : 'Lead UI/UX Designer',
    'about.t4.bio'        : 'Design specialist in user experience, turning complex ideas into simple, beautiful interfaces',
    'about.tl.tag'        : 'Our Journey',
    'about.tl.title'      : 'A <span class="text-teal">5-Year</span> Journey of Innovation',
    'about.tl.y1'         : '2019',
    'about.tl.h1'         : 'The Beginning',
    'about.tl.d1'         : 'We founded LogTea with a team of 3 developers and a big dream: to make a difference in the Arab technology landscape.',
    'about.tl.y2'         : '2020',
    'about.tl.h2'         : 'First 10 Clients',
    'about.tl.d2'         : 'We completed our first 10 projects successfully and built a strong reputation in web development and applications.',
    'about.tl.y3'         : '2021',
    'about.tl.h3'         : 'AI Expansion',
    'about.tl.d3'         : 'We launched our AI division and began offering ML and NLP services to companies in the region.',
    'about.tl.y4'         : '2023',
    'about.tl.h4'         : 'Cyber Security Division',
    'about.tl.d4'         : 'We added a specialized cyber security and penetration testing division, and saw 200% revenue growth.',
    'about.tl.y5'         : '2026',
    'about.tl.h5'         : 'Today — 120+ Projects',
    'about.tl.d5'         : 'We serve 50+ clients in 6 countries, with a team of 20+ specialists across diverse technical fields.',
    'about.tech.tag'      : 'Technologies',
    'about.tech.title'    : 'Our <span class="text-teal">Favorite Tools</span>',
    'about.cta.title'     : 'Join the <span class="text-teal">LogTea</span> Family',
    'about.cta.desc'      : 'Looking for a reliable technology partner who understands your needs and works to achieve your goals?',
    'about.cta.btn1'      : 'Contact Us Now',
    'about.cta.btn2'      : 'Explore Services',

    /* ── SERVICES ── */
    'svc.title'           : 'LogTea | Services',
    'svc.bread'           : 'Services',
    'svc.banner.title'    : 'Comprehensive <span class="text-teal">Tech Solutions</span>',
    'svc.banner.desc'     : 'From artificial intelligence to cyber security — we offer a full spectrum of technology services to digitally transform your business',
    'svc.banner.btn1'     : 'Get a Free Consultation',
    'svc.banner.btn2'     : 'Explore Services',
    'svc.ai.title'        : 'AI Solutions',
    'svc.ai.ar'           : 'Artificial Intelligence Solutions',
    'svc.ai.desc'         : 'We build custom AI solutions that solve real problems in your business. From predictive models to natural language processing and computer vision.',
    'svc.ai.f1'           : 'Custom Machine Learning models for your data',
    'svc.ai.f2'           : 'Natural Language Processing (NLP) in Arabic & English',
    'svc.ai.f3'           : 'Computer vision for image and video recognition',
    'svc.ai.f4'           : 'Intelligent Process Automation (RPA + AI)',
    'svc.ai.f5'           : 'Integration with OpenAI, Claude, and Gemini models',
    'svc.ai.f6'           : 'Custom chatbots and intelligent assistants',
    'svc.web.title'       : 'Web Development',
    'svc.web.ar'          : 'Full-Stack Web Development',
    'svc.web.desc'        : 'We build modern, high-performance web applications combining exceptional user experience with beautiful design. From landing pages to complex platforms.',
    'svc.web.f1'          : 'High-performance React / Next.js applications',
    'svc.web.f2'          : 'Powerful Backend APIs with Node.js and Python',
    'svc.web.f3'          : 'Efficient Laravel / PHP websites',
    'svc.web.f4'          : 'Professional responsive UI/UX design',
    'svc.web.f5'          : 'Technical Search Engine Optimization (SEO)',
    'svc.web.f6'          : 'Progressive Web Apps (PWA)',
    'svc.sec.title'       : 'Cyber Security',
    'svc.sec.ar'          : 'Advanced Cyber Security',
    'svc.sec.desc'        : 'We protect your digital assets from sophisticated cyber threats. Our security experts are internationally certified with extensive experience in discovering vulnerabilities.',
    'svc.sec.f1'          : 'Comprehensive Penetration Testing',
    'svc.sec.f2'          : 'Vulnerability Assessment (VAPT) for apps and networks',
    'svc.sec.f3'          : 'Security source code audit',
    'svc.sec.f4'          : 'Detailed report with remediation plan',
    'svc.sec.f5'          : 'Security awareness team training',
    'svc.sec.f6'          : 'Continuous monitoring and early warning',
    'svc.cloud.title'     : 'Cloud Services',
    'svc.cloud.ar'        : 'Cloud Services',
    'svc.cloud.desc'      : 'We design, deploy and manage your cloud infrastructure with efficiency and security. Whether starting from scratch or migrating existing systems.',
    'svc.cloud.f1'        : 'Advanced cloud architecture design (AWS / Azure / GCP)',
    'svc.cloud.f2'        : 'Smooth migration of existing systems to the cloud',
    'svc.cloud.f3'        : 'CI/CD Pipelines and deployment automation',
    'svc.cloud.f4'        : 'Docker and Kubernetes container orchestration',
    'svc.cloud.f5'        : 'Performance monitoring and cost management',
    'svc.cloud.f6'        : 'Backup and disaster recovery',
    'svc.api.title'       : 'APIs & Integrations',
    'svc.api.ar'          : 'APIs & Integrations',
    'svc.api.desc'        : 'We connect your systems with each other and with the outside world. We design robust, secure APIs and integrate with hundreds of services and platforms.',
    'svc.api.f1'          : 'REST API design following OpenAPI standards',
    'svc.api.f2'          : 'GraphQL APIs for flexible queries',
    'svc.api.f3'          : 'Integration with Stripe, PayPal, and Sadad',
    'svc.api.f4'          : 'Webhooks and Event-Driven Architecture',
    'svc.api.f5'          : 'CRM, ERP, and accounting system integration',
    'svc.api.f6'          : 'Professional API documentation and testing environment',
    'svc.db.title'        : 'Database Solutions',
    'svc.db.ar'           : 'Database Solutions',
    'svc.db.desc'         : 'We design and manage high-performance databases. From technical consulting to schema design and performance optimization.',
    'svc.db.f1'           : 'Database Schema Design',
    'svc.db.f2'           : 'Query Optimization for maximum performance',
    'svc.db.f3'           : 'Relational and non-relational databases',
    'svc.db.f4'           : 'Data migration and transformation',
    'svc.db.f5'           : 'Replication and distribution',
    'svc.db.f6'           : 'Backup and disaster recovery plan',
    'svc.proc.tag'        : 'How We Work',
    'svc.proc.title'      : 'From Idea to <span class="text-teal">Launch</span>',
    'svc.proc.h1'         : 'Consultation',
    'svc.proc.d1'         : 'We understand your needs and goals',
    'svc.proc.h2'         : 'Planning',
    'svc.proc.d2'         : 'A clear project roadmap',
    'svc.proc.h3'         : 'Development',
    'svc.proc.d3'         : 'Building to the highest quality standards',
    'svc.proc.h4'         : 'Launch',
    'svc.proc.d4'         : 'We launch and continue support',
    'svc.faq.tag'         : 'FAQ',
    'svc.faq.title'       : 'Answers to <span class="text-teal">Your Questions</span>',
    'svc.faq.q1'          : 'How long does it take to develop a professional website?',
    'svc.faq.a1'          : 'Time depends on project complexity. A simple brochure site takes 2-3 weeks, while complex platforms may need 3-6 months. We set a detailed timeline at the start of each project and commit to it.',
    'svc.faq.q2'          : 'Do you provide a warranty after delivery?',
    'svc.faq.a2'          : 'Yes, we provide a free 3-month maintenance warranty after launch to fix any issues that arise. We also offer monthly and annual support plans at reasonable prices.',
    'svc.faq.q3'          : 'How is pricing determined?',
    'svc.faq.a3'          : 'We offer two pricing models: fixed price for projects with defined requirements, or hourly rate for flexible and ongoing projects. Pricing is set after fully understanding your requirements and defining the project scope.',
    'svc.faq.q4'          : 'Can you work with our internal technical team?',
    'svc.faq.a4'          : 'Absolutely! We work collaboratively with internal teams. We can provide specialized expertise to complement your team, take full ownership, or any hybrid model that suits your needs.',
    'svc.faq.q5'          : 'What payment methods are available?',
    'svc.faq.a5'          : 'We accept bank transfer, MADA, Visa, MasterCard, and some electronic payment services. We typically require 40% upfront, 40% mid-project, and 20% upon final delivery.',
    'svc.faq.q6'          : 'Do you work with companies outside Saudi Arabia?',
    'svc.faq.a6'          : 'Yes, we serve clients in 6+ countries in the Arab region. Remote work doesn\'t affect our communication quality — we use professional tools to ensure smooth and effective collaboration.',
    'svc.cta.title'       : 'Ready to Start? <span class="text-teal">First Consultation is Free</span>',
    'svc.cta.desc'        : 'Talk to our team and get a free evaluation of your project',
    'svc.cta.btn1'        : 'Book a Free Consultation',
    'svc.cta.btn2'        : 'See Our Work First',

    /* ── PORTFOLIO ── */
    'port.title'          : 'LogTea | Our Work',
    'port.bread'          : 'Our Work',
    'port.banner.title'   : 'Projects We <span class="text-teal">Are Proud Of</span>',
    'port.banner.desc'    : '120+ successful projects across various sectors and industries — from startups to large enterprises',
    'port.banner.s1'      : 'Completed Projects',
    'port.banner.s2'      : 'Happy Clients',
    'port.banner.s3'      : 'Countries in the Region',
    'port.banner.s4'      : 'Client Satisfaction',
    'port.spot.tag'       : 'Featured Case Study',
    'port.spot.title'     : 'A <span class="text-teal">Spotlight</span> Project',
    'port.spot.label'     : 'FinTech · AI · Security',
    'port.spot.cs'        : 'Smart Wealth Management Platform',
    'port.spot.desc'      : 'We built a comprehensive wealth and investment management platform with an AI-powered recommendation system. The platform analyzes user financial behavior and suggests personalized investment strategies in real-time.',
    'port.spot.s1'        : 'Active Users',
    'port.spot.s2'        : 'Recommendation Accuracy',
    'port.spot.s3'        : 'Response Time',
    'port.spot.btn'       : 'I want a similar project',
    'port.grid.tag'       : 'All Projects',
    'port.grid.title'     : 'Browse Our <span class="text-teal">Work</span>',
    'port.f.all'          : 'All',
    'port.p1.title'       : 'Smart Business Management Platform',
    'port.p1.desc'        : 'AI-powered ERP with real-time analytics, interactive dashboards and smart reports',
    'port.p2.title'       : 'Security Audit for Digital Bank',
    'port.p2.desc'        : 'Comprehensive penetration testing and security assessment for a banking platform serving 500K+ users',
    'port.p3.title'       : 'Cloud Migration for Logistics Company',
    'port.p3.desc'        : 'Full migration of 30+ servers to AWS with 40% cost reduction and major performance improvement',
    'port.p4.title'       : 'AI Recommendation for E-Learning Platform',
    'port.p4.desc'        : 'Custom content recommendation algorithm analyzing 50K+ learners and suggesting optimal learning paths',
    'port.p5.title'       : 'Full E-Commerce Platform',
    'port.p5.desc'        : 'Integrated online store with smart inventory, secure multi-gateway payments, and mobile app',
    'port.p6.title'       : 'API Gateway for Government Services',
    'port.p6.desc'        : 'Design and build a unified gateway connecting 15+ government services with Rate Limiting',
    'port.p7.title'       : 'AI Fraud Detection System',
    'port.p7.desc'        : 'AI system detecting fraudulent transactions in real-time with 96% accuracy for an e-payment company',
    'port.p8.title'       : 'Telemedicine Platform',
    'port.p8.desc'        : 'Integrated medical platform connecting patients with doctors with video support and AI-assisted initial diagnosis',
    'port.clients.tag'    : 'Our Clients',
    'port.clients.title'  : 'Partners We <span class="text-teal">Are Proud Of</span>',
    'port.clients.desc'   : 'From startups to large enterprises — we serve all sizes and sectors',
    'port.cta.title'      : 'Your <span class="text-teal">Next Project</span> is Here',
    'port.cta.desc'       : 'Join our list of successful clients and transform your idea into a great product',
    'port.cta.btn1'       : 'Start Your Project Now',
    'port.cta.btn2'       : 'Explore Our Services',

    /* ── BLOG ── */
    'blog.title'          : 'LogTea | Blog',
    'blog.bread'          : 'Blog',
    'blog.banner.title'   : 'Tech Insights & <span class="text-teal">Real Experiences</span>',
    'blog.banner.desc'    : 'We share our knowledge and experiences in the world of technology — practical articles that help you make smarter technical decisions',
    'blog.banner.btn1'    : 'Start Reading',
    'blog.banner.btn2'    : 'Subscribe to Newsletter',
    'blog.feat.tag'       : 'Featured Article',
    'blog.feat.title'     : 'The <span class="text-teal">Best</span> We Published',
    'blog.feat.cat'       : 'AI & LLMs',
    'blog.feat.h'         : 'How to Build an AI Agent for Your Business from Scratch',
    'blog.feat.desc'      : 'A comprehensive, practical guide to building a specialized AI Agent for your business using LangChain and OpenAI, with real code examples and strategies for handling complex cases.',
    'blog.feat.m1'        : '📅 June 14, 2026',
    'blog.feat.m2'        : '⏱ 12 min read',
    'blog.feat.m3'        : '👁 4,280 views',
    'blog.feat.btn'       : 'Read Full Article',
    'blog.grid.tag'       : 'All Articles',
    'blog.grid.title'     : 'Browse by <span class="text-teal">Topic</span>',
    'blog.b1.title'       : 'The Future of AI in Software Development',
    'blog.b1.desc'        : 'How large AI models are changing the way code is written and systems are designed, and what role developers play in the future?',
    'blog.b1.meta'        : 'June 10, 2026 · 8 min',
    'blog.b1.author'      : 'Noura Al-Qahtani',
    'blog.b2.title'       : 'OWASP Top 10: The Most Dangerous Vulnerabilities',
    'blog.b2.desc'        : 'A practical guide to understanding the most dangerous web vulnerabilities with real code examples and how to tackle each one',
    'blog.b2.meta'        : 'June 5, 2026 · 10 min',
    'blog.b2.author'      : 'Ali Al-Ghamdi',
    'blog.b3.title'       : 'Kubernetes in Production: Common Mistakes to Avoid',
    'blog.b3.desc'        : 'Real experiences from large projects — mistakes teams make when deploying Kubernetes and how to avoid them',
    'blog.b3.meta'        : 'June 1, 2026 · 7 min',
    'blog.b3.author'      : 'Mohammed Al-Shahri',
    'blog.b4.title'       : 'Next.js 15: Everything You Need to Know',
    'blog.b4.desc'        : 'A comprehensive guide to new features in Next.js 15 with practical examples and best practices',
    'blog.b4.meta'        : 'May 25, 2026 · 9 min',
    'blog.b4.author'      : 'Reem Al-Dosari',
    'blog.b5.title'       : 'Building a Tech Career in 2026: A Roadmap',
    'blog.b5.desc'        : 'A practical roadmap for aspiring developers: the most in-demand skills and mistakes to avoid',
    'blog.b5.meta'        : 'May 20, 2026 · 6 min',
    'blog.b5.author'      : 'Mohammed Al-Shahri',
    'blog.b6.title'       : 'CI/CD from Scratch with GitHub Actions',
    'blog.b6.desc'        : 'Build a complete pipeline from development to production with automated testing and safe deployment',
    'blog.b6.meta'        : 'May 15, 2026 · 11 min',
    'blog.b6.author'      : 'Ali Al-Ghamdi',
    'blog.load'           : 'Load More Articles',
    'blog.nl.title'       : 'Never Miss a New Article',
    'blog.nl.desc'        : 'Subscribe to our weekly newsletter and get the best tech articles directly in your inbox',
    'blog.nl.ph'          : 'Your email address',
    'blog.nl.btn'         : 'Subscribe Now',
    'blog.nl.sub'         : '✓ No spam · ✓ Unsubscribe anytime · ✓ 2,000+ subscribers',
    'blog.tags.tag'       : 'Tags',
    'blog.tags.title'     : 'Browse by <span class="text-teal">Tags</span>',

    /* ── CONTACT ── */
    'contact.title'       : 'LogTea | Contact Us',
    'contact.bread'       : 'Contact',
    'contact.banner.title': 'Let\'s Build <span class="text-teal">Together</span>',
    'contact.banner.desc' : 'Have an idea or project? Our team is ready to listen and turn your vision into a polished digital solution — your first consultation is completely free',
    'contact.banner.s1'   : 'Response Time',
    'contact.banner.s2'   : 'Free',
    'contact.banner.s3'   : 'Technical Support',
    'contact.banner.s4'   : 'Confidentiality',
    'contact.banner.sl2'  : 'First Consultation',
    'contact.tag'         : 'Contact Us',
    'contact.title2'      : 'We\'d love to hear <span class="text-teal">your idea</span>',
    'contact.desc'        : 'Whether you have a clear project or just a rough idea — we\'re here to listen and help you map out the right path forward.',
    'contact.map'         : 'Riyadh, Saudi Arabia',
    'contact.map.sub'     : 'Al-Olaya District, King Fahad Road',
    'contact.c1.label'    : 'Email',
    'contact.c1.sub'      : 'We reply within 24 business hours',
    'contact.c2.label'    : 'Phone / WhatsApp',
    'contact.c2.sub'      : 'Available 9AM — 10PM (Riyadh time)',
    'contact.c3.label'    : 'Headquarters',
    'contact.c3.value'    : 'Riyadh, Saudi Arabia',
    'contact.c3.sub'      : 'We work remotely with Arab region clients',
    'contact.hours.title' : '⏰ Business Hours',
    'contact.h1.day'      : 'Sunday — Thursday',
    'contact.h1.time'     : '9:00 AM — 10:00 PM',
    'contact.h2.day'      : 'Friday',
    'contact.h2.time'     : '2:00 PM — 8:00 PM',
    'contact.h3.day'      : 'Saturday',
    'contact.h3.time'     : '10:00 AM — 6:00 PM',
    'contact.h4.day'      : 'Emergency Support',
    'contact.h4.time'     : 'Available 24/7',
    'contact.social'      : 'Follow Us On',
    'contact.form.title'  : 'Send Us a Message 💬',
    'contact.f.name'      : 'Full Name *',
    'contact.f.name.ph'   : 'Mohammed Ahmed',
    'contact.f.email'     : 'Email Address *',
    'contact.f.phone'     : 'Phone / WhatsApp',
    'contact.f.phone.ph'  : '+966 5X XXX XXXX',
    'contact.f.company'   : 'Company Name',
    'contact.f.company.ph': 'Your company name (optional)',
    'contact.f.service'   : 'Required Service *',
    'contact.f.budget'    : 'Estimated Budget',
    'contact.f.message'   : 'Project Description *',
    'contact.f.message.ph': 'Tell us about your project, the problem you want to solve, and the results you\'re aiming for...',
    'contact.f.source'    : 'How did you hear about us?',
    'contact.f.btn'       : 'Send Your Message',
    'contact.f.privacy'   : '🔒 Your data is protected and will not be shared with any third party',
    'contact.faq.tag'     : 'FAQ',
    'contact.faq.title'   : 'Questions We <span class="text-teal">Hear Often</span>',
    'contact.faq.q1'      : 'How quickly will you respond to my message?',
    'contact.faq.a1'      : 'We respond to all messages within 24 business hours. For urgent cases, you can contact us via WhatsApp for an immediate response.',
    'contact.faq.q2'      : 'Is the first consultation really free?',
    'contact.faq.a2'      : 'Yes, the first consultation is completely free with no obligation. We\'ll understand your needs and give you our honest opinion, even if you don\'t proceed with us.',
    'contact.faq.q3'      : 'How is my project\'s confidentiality protected?',
    'contact.faq.a3'      : 'We sign a Non-Disclosure Agreement (NDA) with every client before any technical discussion. The confidentiality of your project is part of our ethical and legal contract.',
    'contact.faq.q4'      : 'Can I reach out outside of business hours?',
    'contact.faq.a4'      : 'You can send a message anytime via the form or email. For emergency support on ongoing projects, we have a 24/7 support line available to our current clients.',
    'contact.faq.q5'      : 'What happens after I send a message?',
    'contact.faq.a5'      : 'After receiving your message, the specialist team reviews your requirements and contacts you to schedule a free online consultation where we explore the project in detail.',
    'contact.cta.title'   : 'Ready to Start? <span class="text-teal">So Are We!</span>',
    'contact.cta.desc'    : 'Don\'t wait — your great idea deserves to become a reality today, not tomorrow',
    'contact.cta.btn1'    : 'Send Your Message Now',
    'contact.cta.btn2'    : 'See Our Work First',
    'contact.f.service.ph': 'Select Service',
    'contact.f.source.ph' : 'Select',
    'contact.opt.ai'      : 'AI Solutions',
    'contact.opt.web'     : 'Web Development',
    'contact.opt.sec'     : 'Cyber Security',
    'contact.opt.cloud'   : 'Cloud Services',
    'contact.opt.api'     : 'APIs & Integrations',
    'contact.opt.db'      : 'Database Solutions',
    'contact.opt.consult' : 'Technical Consultation',
    'contact.opt.other'   : 'Other',
    'contact.src.google'  : 'Google Search',
    'contact.src.linkedin': 'LinkedIn',
    'contact.src.twitter' : 'Twitter / X',
    'contact.src.ref'     : 'Referral',
    'contact.src.article' : 'Article or Content',

    /* ── SERVICE BAR (index) ── */
    'bar.ai'              : 'AI Solutions',
    'bar.ai.sub'          : 'Artificial Intelligence',
    'bar.web'             : 'Web Development',
    'bar.web.sub'         : 'Full-Stack Development',
    'bar.sec'             : 'Cyber Security',
    'bar.sec.sub'         : 'Advanced Security',
    'bar.cloud'           : 'Cloud Services',
    'bar.cloud.sub'       : 'Cloud Infrastructure',
    'bar.api'             : 'APIs & Integrations',
    'bar.api.sub'         : 'Programming Interfaces',

    /* ── TECH STACK GROUPS ── */
    'tech.fe'             : 'Frontend',
    'tech.be'             : 'Backend & APIs',
    'tech.ai'             : 'AI & Machine Learning',
    'tech.cloud'          : 'Cloud & DevOps',

    /* ── MISC ── */
    'index.svc.badge'     : 'Most Popular',
    'index.about.acf'     : 'Execution Speed',
    'index.about.acfs'    : 'From idea to product',
    'about.story.scf'     : '120+ Successful Projects',
    'bread.home'          : 'Home',
  };

  // ── Engine ──────────────────────────────────────────────────
  const LangManager = {
    get current() { return _stored; },
    _lang: _stored,

    t(key) {
      return EN[key];
    },

    apply() {
      const lang = this._lang;
      const html = document.documentElement;
      html.lang = lang;
      html.dir = lang === 'ar' ? 'rtl' : 'ltr';
      html.setAttribute('data-lang', lang);

      // Font
      document.body.style.fontFamily =
        lang === 'en' ? "'Poppins', sans-serif" : "'Cairo', sans-serif";

      const action = lang === 'en'
        ? (el, attr, prop) => {
            if (!el.hasAttribute('data-orig-' + attr))
              el.setAttribute('data-orig-' + attr, el[prop]);
            const v = EN[el.getAttribute('data-i18n' + (attr === 'text' ? '' : '-' + attr))];
            if (v !== undefined) el[prop] = v;
          }
        : (el, attr, prop) => {
            const orig = el.getAttribute('data-orig-' + attr);
            if (orig !== null) el[prop] = orig;
          };

      // textContent
      document.querySelectorAll('[data-i18n]').forEach(el => action(el, 'text', 'textContent'));
      // innerHTML (elements with inner HTML like spans)
      document.querySelectorAll('[data-i18n-html]').forEach(el => {
        if (lang === 'en') {
          if (!el.hasAttribute('data-orig-html')) el.setAttribute('data-orig-html', el.innerHTML);
          const v = EN[el.getAttribute('data-i18n-html')];
          if (v !== undefined) el.innerHTML = v;
        } else {
          const o = el.getAttribute('data-orig-html');
          if (o) el.innerHTML = o;
        }
      });
      // Placeholders
      document.querySelectorAll('[data-i18n-ph]').forEach(el => {
        if (lang === 'en') {
          if (!el.hasAttribute('data-orig-ph')) el.setAttribute('data-orig-ph', el.placeholder);
          const v = EN[el.getAttribute('data-i18n-ph')];
          if (v !== undefined) el.placeholder = v;
        } else {
          const o = el.getAttribute('data-orig-ph');
          if (o) el.placeholder = o;
        }
      });

      // Toggle button
      const btn = document.getElementById('langToggle');
      if (btn) {
        btn.innerHTML = lang === 'ar'
          ? '<span class="lt-flag">🌐</span> EN'
          : '<span class="lt-flag">🌐</span> عربي';
      }

      // Page title
      if (document.body) {
        const titleKey = document.body.getAttribute('data-i18n-title');
        if (titleKey) {
          if (lang === 'en') {
            if (!document.body.hasAttribute('data-orig-title'))
              document.body.setAttribute('data-orig-title', document.title);
            const t = EN[titleKey];
            if (t) document.title = t;
          } else {
            const orig = document.body.getAttribute('data-orig-title');
            if (orig) document.title = orig;
          }
        }
      }
    },

    toggle() {
      this._lang = this._lang === 'ar' ? 'en' : 'ar';
      localStorage.setItem('lt_lang', this._lang);
      this.apply();
    }
  };

  // Expose globally
  LangManager._lang = _stored;
  window.LangManager = LangManager;
})();
