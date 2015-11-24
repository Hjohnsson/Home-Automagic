import time
import MySQLdb
from decimal import *
import datetime

count = 0
count_H = 0
TEMP_MIN = []
TEMP_H = []
min_result = 0
h_result = 0
not_valid_value = 0

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
	count += 1
	if TEMP =="":
		print "Not a valid value"
		print "-"
		TEMP = 0
		not_valid_value +=1
		time.sleep(1)
	else:
		TEMP = Decimal(TEMP)/Decimal(10)
		mysql_update_value("temp","tblCurrentTemp","Temperatur",TEMP,'NULL','NULL')

		TEMP1 = TEMP

		TIMESTAMP = datetime.datetime.now().time()
		TEXT = " Current temperature :"
		print str(TIMESTAMP) + TEXT + str(TEMP1)

		TEMP_MIN.append(TEMP)
		print "-"
		if count == 60:	#En minut har gått
			count = 0	
			count_H += 1

			for i in TEMP_MIN:
				debug_print ("-.-")
				min_result += i
				debug_print(min_result)


			del TEMP_MIN[:]
			getcontext().prec = 4
			flyt = Decimal(min_result)/Decimal(10-not_valid_value)
			debug_print(flyt)
			debug_print(min_result)
			debug_print(not_valid_value)
			print "-----------"
			print "60 seconds average value = "	+ str((Decimal(min_result)/Decimal(10-not_valid_value)))
			print "-----------"
			not_valid_value = 0

			#TEMP_H.append(flyt)
			#Databas,Table,Column,Value,Where
			#mysql_update_value("temp","temperatur","Temperatur",flyt,'MIN')
			mysql_insert_value("temp","temperatur","Temperatur",flyt)

			min_result = 0

		#if count_H ==60:
			#count_H = 0
			#for i in TEMP_H:
				#h_result = h_result + int(i)

			#del TEMP_H[:]

			#getcontext().prec = 4
			#flyt_h = Decimal(h_result)/Decimal(60)
			#print "-----------"
			#print " 60 Minute value = " + str((Decimal(h_result)/Decimal(60)))
			#print "-----------"

			#mysql_update_value("temp","temperatur","Temperatur",flyt_h,'H')


		time.sleep(1)
