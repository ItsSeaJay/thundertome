from random import randint
from factory import Factory
import lipsum
import os # Operating system
import re # Regular expressions
import sys # System
import string

class Entry_Factory(Factory):
	def __init__(self):
		pass

	def create(self):
		self.config = self.get_config()
		# Get how many entries will be inserted by the query
		total_entries = int(input('Enter the number of entries [1]: ') or 1)
		# Get the path to the new sql file
		path = self.config['project']['path'] + 'insert_entries.sql'

		# Clear the contents of the file with the first entry
		with open(path, 'w') as file:
			print('Writing first entry to file...')
			file.write(self.get_template(self.get_entry()))

		# Append the rest of the entries to the end of the file
		for entry in range(0, total_entries - 1):
			print('Appending new entry to file...')

			template = self.get_template(self.get_entry())
			
			with open(path, 'a') as file:
				file.write('\n' + template)

	def generate_uri(self, title, delimiter = '_'):
		uri = title
		# Remove every character that isn't alphanumeric or valid as a URL
		uri = re.sub(r'[^a-zA-Z0-9/_|+ -]', '', uri)
		# Convert the URI to lower case
		uri = uri.lower()
		# Replace all remaining non alphanumeric characters with the delimiter
		uri = re.sub(r'[/_|+ -]+', delimiter, uri)

		print(uri)

		return uri

	def get_entry(self):
		entry = {}
		entry['title'] = lipsum.generate_words(randint(1, 8)).title()
		entry['uri'] = self.generate_uri(entry['title'])
		entry['content'] = lipsum.generate_sentences(randint(4, 12)).replace("'", "\\'")
		entry['year'] = str(randint(2008, 2018))
		entry['month'] = str(randint(1, 12))
		entry['day'] = str(randint(1, 28))

		return entry

	def get_template(self, entry):
		with open('templates/queries/insert_entry.sql', 'r') as file:
			template = file.read()
			template = template.format(
				uri = entry['uri'],
				title = entry['title'],
				content = entry['content'],
				date = entry['year'] + '-' + entry['month'] + '-' + entry['day'],
				year = entry['year'],
				month = entry['month'],
				day = entry['day']
			)

		return template

factory = Entry_Factory()
factory.create()
