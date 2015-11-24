import time
import MySQLdb
from decimal import *
import datetime

number_of_seconds = 0
number_of_seconds_H = 0
TEMP_MINUTE = []
TEMP_H = []
minute_result = 0
h_result = 0
non_valid_values = 0

SECONDS_BETWEEN_UPDATES = 3

debug = 0


def debug_print(debug_text):
	if debug ==1:
		print "Debug :" + str(debug_text)

def mysql_update_value(DB,TABLE,COLUMN,VALUE,COLUMN2,VALUE2):
		db = MySQLdb.connect("localhost","root","hj",DB)
		cursor = db.cursor()
                if COLUMN2 == "NULL":
			sql = """UPDATE %s SET %s = ('%s')""" % (TABLE,COLUMN,VALUE)
		else:
			sql = """UPDATE %s SET %s = ('%s') WHERE %s=('%s')""" % (TABLE,COLUMN,VALUE,COLUMN2,VALUE2)
		try:
			cursor.execute(sql)
			db.commit()
			debug_print("Succesfull update to database")
		except:
			db.rollback()
			print "error mysql"
		db.close()


def mysql_insert_value(DB,TABLE,COLUMN,VALUE):
		db = MySQLdb.connect("localhost","root","hj",DB)
		cursor = db.cursor()
		sql = """INSERT INTO %s (%s) VALUES (%s) """ % (TABLE,COLUMN,VALUE)
		try:
			cursor.execute(sql)
			db.commit()
			print "Succesfull insert into database"
			print "-"
		except:
			db.rollback()
			print "error mysql"
		db.close()



while True:
	file = open("test.txt","r+")
	TEMP = file.readline()
	file.close()
	number_of_seconds += 1
	if TEMP =="":
		print "Not a valid value"
		print "-"
		TEMP = 0
		non_valid_values +=1
		time.sleep(1)
	else:
		TEMP = Decimal(TEMP)/Decimal(10)
		mysql_update_value("temp","tblCurrentTemp","Temperatur",TEMP,'NULL','NULL')

		TEMP1 = TEMP

		TIMESTAMP = datetime.datetime.now().time()
		TEXT = " Current temperature :"
		print str(TIMESTAMP) + TEXT + str(TEMP1)

		TEMP_MINUTE.append(TEMP)
		print "-"
		if number_of_seconds == SECONDS_BETWEEN_UPDATES:	#En minut har gaatt
			number_of_seconds = 0
			number_of_seconds_H += 1

			for i in TEMP_MINUTE:
				debug_print ("-.-")
				minute_result += i
				debug_print(minute_result)


			del TEMP_MINUTE[:]
			getcontext().prec = 4
			flyt = Decimal(minute_result)/Decimal(SECONDS_BETWEEN_UPDATES-non_valid_values)
			debug_print(flyt)
			debug_print(minute_result)
			debug_print(non_valid_values)
			print "-----------"
			print str(SECONDS_BETWEEN_UPDATES) + " seconds average value = "	+ str((Decimal(minute_result)/Decimal(SECONDS_BETWEEN_UPDATES-non_valid_values)))
			print "-----------"
			non_valid_values = 0

			#TEMP_H.append(flyt)
			#Databas,Table,Column,Value,Where
			#mysql_update_value("temp","temperatur","Temperatur",flyt,'MIN')
			mysql_insert_value("temp","temperatur","Temperatur",flyt)

			minute_result = 0

		#if number_of_seconds_H ==60:
			#number_of_seconds_H = 0
			#for i in TEMP_H:
				#h_result = h_result + int(i)

			#del TEMP_H[:]

			#getcontext().prec = 4
			#flyt_h = Decimal(h_result)/Decimal(60)
			#print "-----------"
			#print " 60 Minute value = " + str((Decimal(h_result)/Decimal(60)))
			#print "-----------"

			mysql_insert_value("temp","tblHTemp","Temperatur",flyt_h,'H')


		time.sleep(1)
