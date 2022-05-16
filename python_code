import telebot
from telebot import types
import face_recognition
import os
import rsa
from random import randint
import hashlib
import re



flag = {}


token='5336982613:AAGu0wgOk0CWmXpxwXqZKWBo0b22XK7IWmI'
bot = telebot.TeleBot(token)

start_mes = 'Вітаю! Оберіть потрібну Вам кнопку.'


@bot.message_handler(commands=['start'])
def start(message):
    global id_user
    id_user = message.chat.id
    markup = types.ReplyKeyboardMarkup(resize_keyboard=True)
             
    markup = types.ReplyKeyboardMarkup(resize_keyboard=True)
    item1 = types.KeyboardButton("Формування ЕЦП")
    markup.add(item1)
    
    item2 = types.KeyboardButton('Верифікація ЕЦП')
    markup.add(item2)
    
    bot.send_message(message.chat.id, start_mes, reply_markup=markup)




@bot.message_handler(content_types='text')
def message_reply(message):
    global id_user, flag
    id_user = message.chat.id
    
    if message.text=="Формування ЕЦП":
        flag[id_user] = 'formation'
        files = os.listdir('img/')
        
        
        if str(id_user) + '_identification .jpeg' in files:
            bot.send_message(message.chat.id, 'Надішліть, будь ласка, документ, який необхідно підписати.')
        else:
            find_face = False
            while not find_face:
                markup = types.InlineKeyboardMarkup()
                button_items = types.InlineKeyboardButton('Зареєструватись', callback_data='dep_items_ru', url='https://github.com/sybrenstuvel/python-rsa/blob/76c0e6901cde36743fd6cbb5251a91bfb3a3352d/rsa/prime.py#L65')
                markup.add(button_items)
                bot.send_message(message.chat.id, 'Перейди на сайт и регни ебло', reply_markup=markup)
                files = os.listdir()
                #ПРОВЕРКА ТОГО ЧТО ОН СКИНУЛ
                src_reg = 'img\\' + str(id_user) + '_registration .jpeg'

                unknown_image = face_recognition.load_image_file(src_reg)

                face_locations = face_recognition.face_locations(unknown_image)

                if len(face_locations) != 1:
                    bot.reply_to(message, "Це фото не підходить, спробуйте знов.")
                    os.remove(src_reg)
                else:
                    find_face = True
                    
                    
    elif message.text=="Верифікація ЕЦП":
        flag[id_user] = 'verification'
        
        bot.send_message(message.chat.id, 'Надішліть, будь ласка, документ, який треба верифікувати')
        
        
    elif len(message.text) > 350 and flag[id_user] == 'verification':
        bot.send_message(message.chat.id, 'Проводжу верифікацію...')
        key = message.text
        keys = [int(i) for i in re.findall(r'\d+', key)]
        e = keys[0]
        n = keys[1]
        signature = keys[2]
        new_hash = pow(signature, e, n)
        if int(doc_ver_hash, 16) == new_hash:
            bot.send_message(message.chat.id, 'Верифікація успішна!')
        else:
            bot.send_message(message.chat.id, 'Нажаль, верифікацію не пройдено!')
        
    @bot.message_handler(content_types=['document'])
    def handle_file(message):
        id_user = message.chat.id
        chat_id = message.chat.id
        file_info = bot.get_file(message.document.file_id)
        downloaded_file = bot.download_file(file_info.file_path)
        doc_src = message.document.file_name;
        with open(doc_src, 'wb') as new_file:
            new_file.write(downloaded_file)
        if flag[id_user] == 'formation':
            find_face = False
            while not find_face:
                markup = types.InlineKeyboardMarkup()
                button_items = types.InlineKeyboardButton('Перейти', callback_data='dep_items_ru', url='https://github.com/sybrenstuvel/python-rsa/blob/76c0e6901cde36743fd6cbb5251a91bfb3a3352d/rsa/prime.py#L65')
                markup.add(button_items)
                bot.send_message(message.chat.id, 'Перейди на сайт и скинь фото', reply_markup=markup)
#                 files = os.listdir()
                #ПРОВЕРКА ТОГО ЧТО ОН СКИНУЛ
                src_id = 'img\\' + str(id_user) + '_identification .jpeg'

                unknown_image = face_recognition.load_image_file(src_id)

                face_locations = face_recognition.face_locations(unknown_image)

                if len(face_locations) != 1:
                    bot.reply_to(message, "Це фото не підходить, спробуйте знов.")
                    os.remove(src_id)
                else:
                    bot.send_message(message.chat.id, "Перевіряю чи це Ви...")
                    src_reg = 'img\\' + str(id_user) + '_registration .jpeg'
                    image_in_f = face_recognition.load_image_file(src_reg)
                    image_in_f_encoding = face_recognition.face_encodings(image_in_f)[0]
                    known_faces = [
                        image_in_f_encoding
                    ]
                    unknown_face_encoding = face_recognition.face_encodings(unknown_image)[0]
                    results = face_recognition.compare_faces(known_faces, unknown_face_encoding)
                    if results[0] == True:
                        find_face = True
                        bot.send_message(message.chat.id, 'Ідентифікацію пройдено успішно.')
                        bot.send_message(message.chat.id, 'Формую підпис...')

                        #створення хешу
                        with open(doc_src, 'rb') as new_file:
                            hash_obj = hashlib.sha1()
                            while True:
                                data = new_file.read(2**20)
                                if not data:
                                    break
                                hash_obj.update(data)

                        doc_hash = hash_obj.hexdigest()
                        bot.send_message(message.chat.id, doc_hash)

                        #створення ключів
                        def prime_test(n: int) -> bool:

                            if n < 10:
                                return n in {2, 3, 5, 7}

                            if not (n & 1):
                                return False   #перевірка на парність

                            if n < 2:
                                return False


                            bitsize = n.bit_length()  #розрахунок кулькості бітів

                            if bitsize >= 1536:
                                k = 3
                            elif bitsize >= 1024:
                                k = 4
                            elif bitsize >= 512:
                                k = 7
                            else:
                                k = 10            #кількість раундів для тестування

                            #підбираємо таке ціле число r, щоб виконувалась рівність (n-1) / 2**r  
                            d = n - 1
                            r = 0

                            while not (d & 1): #поки d парне ділимо його на 2 та збільшуємо r 
                                r += 1
                                d >>= 1

                            #проводимо k тестувань.
                            for _ in range(k):

                                a = randint(2, n - 2)      # обираємо випадкове ціле 2 <= a <= (n - 2)

                                x = pow(a, d, n)
                                if x == 1 or x == n - 1:
                                    continue

                                for _ in range(r - 1):
                                    x = pow(x, 2, n)
                                    if x == 1:
                                        # n складене.
                                        return False
                                    if x == n - 1:
                                        # виходимо з цього for
                                        break
                                else:
                                    # n складене.
                                    return False

                            return True # n високоймовірно просте.

                        def check_len(n: int) -> int:
                            f = 2 ** 512 
                            l = 2 ** 511    
                            while n < l or n > f:
                                if n < l:
                                    n += 6703903964971298549787012499102923063739682910296196688861780721860882015036773488400937149083451713845015929093243025426876941405973284973216814503042048 + id_user
                                if n > f: 
                                    n -= 6703903964971298549787012499102923063739682910296196688861780721860882015036773488400937149083451713845015929093243025426876941405973284973216814503042048
                            return n

                        def find_prime(n: int) -> int:
                            while not prime_test(n):
                                if not (n & 1):
                                    n -= 1
                                else: 
                                    n -= 2
                            return n

                        image_in_f = face_recognition.load_image_file(src_reg)
                        a = face_recognition.face_encodings(image_in_f)[0]
                        k = 0
                        b = 0
                        for i in a:
                            b = i ** 2
                            k += b

                        while k > 2:
                            k -= 0.05

                        k = int(k ** 1024)
                        k = str(k)

                        p = int(k[:int(len(k)/2)])

                        q = int(k[int(len(k)/2):])

                        while p != check_len(p):
                            p = check_len(p)
                            p = find_prime(p)
                        while q != check_len(q):
                            q = check_len(q)
                            q = find_prime(q)
                        n = p * q
                        f = (p-1)*(q-1)
                        e = 65537
                        d = pow(e, -1, f)

                        #підпис
                        signature =  pow(int(doc_hash, 16), d, n)

                        bot.send_message(message.chat.id, 'Ваш відкритий ключ:\n' + str(e) + ';\n' + str(n) + '\nВаш підпис:\n' + str(signature))

                        bot.send_message(message.chat.id, 'Надішліть для перевірки:\n    *ваш документ;\n    *ваш відкритий ключ;\n    *ваш підпис.\n\nЧекаю повернення!')



                        #УДАЛЕНИЕ ФОТО    



                    else:
                        bot.send_message(message.chat.id, 'Ідентифікацію не пройдено')

        elif flag[id_user] == 'verification':
            bot.send_message(message.chat.id, 'Надішліть, будь ласка, відкритий ключ та підпис цього документу')

            #створення хешу
            with open(doc_src, 'rb') as new_file:
                hash_obj = hashlib.sha1()
                while True:
                    data = new_file.read(2**20)
                    if not data:
                        break
                    hash_obj.update(data)
            global  doc_ver_hash
            doc_ver_hash = hash_obj.hexdigest()

            


                            
                            
bot.polling(none_stop=True, interval=0)   
